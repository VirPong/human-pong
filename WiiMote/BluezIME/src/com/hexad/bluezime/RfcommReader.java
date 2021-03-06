/* Copyright (C) 2011, Kenneth Skovhede
 * http://www.hexad.dk, opensource@hexad.dk
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */
package com.hexad.bluezime;

import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothSocket;
import android.content.Context;
import android.content.Intent;
import android.util.Log;

import java.io.InputStream;


/**
 * Abstract class that HIDReaderBase (and by extension WiimoteReader) extends. 
 * In particular, it seems to implement basic functions, like connection and disconnection.
 */
public abstract class RfcommReader implements BluezDriverInterface {

    private static final String LOG_NAME = "RfcommReader - ";

    protected volatile boolean m_isRunning = true;
    protected boolean m_useInsecureChannel = false;

    protected BluetoothSocket m_socket = null;
    protected InputStream m_input = null;
    protected Context m_context = null;
    protected String m_address = null;
    protected String m_name = null;
    protected String m_sessionId = null;
    private Intent m_foregroundServiceIntent = null;

    protected Intent errorBroadcast = new Intent(BluezService.EVENT_ERROR);
    protected Intent connectedBroadcast = new Intent(
            BluezService.EVENT_CONNECTED);
    protected Intent disconnectedBroadcast = new Intent(
            BluezService.EVENT_DISCONNECTED);
    protected Intent keypressBroadcast = new Intent(BluezService.EVENT_KEYPRESS);
    protected Intent directionBroadcast = new Intent(
            BluezService.EVENT_DIRECTIONALCHANGE);
    protected Intent accelerometerBroadcast = new Intent(
            BluezService.EVENT_ACCELEROMETERCHANGE);

    protected ImprovedBluetoothDevice m_device;

    // private static final UUID HID_UUID =
    // UUID.fromString("00001124-0000-1000-8000-00805f9b34fb");
    // private static final UUID SPP_UUID =
    // UUID.fromString("00001101-0000-1000-8000-00805f9b34fb");
    
    /**
     * Wrapper constructor that just calls the other constructor with connect = true.
     */
    public RfcommReader(String address, String sessionId, Context context,
            boolean startnotification) throws Exception {
        this(address, sessionId, context, true, startnotification);
    }

    /**
     * Constructor that starts up the intents and broadcasters.
     * Also runs the adapter functions and connection code.
     * 
     * @param address the ID of the device
     * @param sessionId an ID for the current instance
     * @param context an Android necessary parameter
     * @param connect whether doConnect should be called
     * @param startnotification if there should be a notification of everything starting
     * @throws Exception if anything at all goes wrong
     */
    protected RfcommReader(String address, String sessionId, Context context,
            boolean connect, boolean startnotification) throws Exception {
        try {
            if (startnotification) {
                m_foregroundServiceIntent = new Intent(context,
                        BluezForegroundService.class);
                m_foregroundServiceIntent
                        .setAction(BluezForegroundService.ACTION_START);
                context.startService(m_foregroundServiceIntent);
            }

            m_context = context;
            m_address = address;
            m_sessionId = sessionId;

            errorBroadcast.putExtra(BluezService.SESSION_ID, m_sessionId);
            connectedBroadcast.putExtra(BluezService.SESSION_ID, m_sessionId);
            disconnectedBroadcast
                    .putExtra(BluezService.SESSION_ID, m_sessionId);
            keypressBroadcast.putExtra(BluezService.SESSION_ID, m_sessionId);
            directionBroadcast.putExtra(BluezService.SESSION_ID, m_sessionId);
            accelerometerBroadcast.putExtra(BluezService.SESSION_ID,
                    m_sessionId);

            BluetoothAdapter blue = BluetoothAdapter.getDefaultAdapter();
            if (blue == null)
                throw new Exception(
                        m_context.getString(R.string.bluetooth_unsupported));
            if (!blue.isEnabled())
                throw new Exception(
                        m_context.getString(R.string.error_bluetooth_off));

            blue.cancelDiscovery();

            m_device = new ImprovedBluetoothDevice(
                    blue.getRemoteDevice(address));
            m_name = m_device.getName();

            if (connect)
                doConnect();
        } catch (Exception ex) {
            try {
                if (m_socket != null)
                    m_socket.close();
            } catch (Exception e) {
            }

            m_socket = null;
            Log.d(LOG_NAME + getDriverName(), "Failed to connect to " + address
                    + ", message: " + ex.toString());
            notifyError(ex);

            throw ex;
        }

    }

    /**
     * This method tries to connect the device to the Android phone I believe.
     * 
     * @throws Exception if anything would go wrong during the connection process
     */
    protected void doConnect() throws Exception {
        try {
            //if (D)
             //   Log.d(LOG_NAME, "Connecting to " + m_address);

            byte[] header = new byte[1024];
            int read = -1;

            // We need to do this a few times as that fixes some connection
            // issues
            int retryCount = 5;
            do {
                try {
                    read = setupConnection(m_device, header);

                    retryCount = 0;
                } catch (Exception ex) {
                    if (retryCount == 0)
                        throw ex;

                    try {
                        if (m_socket != null)
                            m_socket.close();
                    } catch (Exception e) {
                    }
                    m_socket = null;
                }
            } while (retryCount-- > 0);

            validateWelcomeMessage(header, read);

            connectedBroadcast.putExtra(BluezService.EVENT_CONNECTED_ADDRESS,
                    m_address);
            m_context.sendBroadcast(connectedBroadcast);
        } catch (Exception ex) {
            try {
                if (m_socket != null)
                    m_socket.close();
            } catch (Exception e) {
            }

            m_socket = null;
            Log.d(LOG_NAME + getDriverName(), "Failed to connect to "
                    + m_address + ", message: " + ex.toString());
            notifyError(ex);

            throw ex;
        }
    }

    /**
     * Perhaps this method is a helper method for doConnect?
     * 
     * @param device The device to connect to
     * @param readBuffer
     * @return
     * @throws Exception if connection or reading goes wrong
     */
    protected int setupConnection(ImprovedBluetoothDevice device,
            byte[] readBuffer) throws Exception {
        m_socket = m_useInsecureChannel ? device.createInsecureRfcommSocket(1)
                : device.createRfcommSocket(1);
        m_socket.connect();

        m_input = m_socket.getInputStream();
        return m_input.read(readBuffer);
    }
    
    /**
     * Doesn't seem to be used, as any implementation of this method is left blank...
     * 
     * @param data 
     * @param read
     */
    protected abstract void validateWelcomeMessage(byte[] data, int read);

    @Override
    public String getDeviceAddress() {
        return m_address;
    }

    @Override
    public String getDeviceName() {
        return m_name;
    }

    @Override
    public abstract String getDriverName();

    @Override
    public boolean isRunning() {
        return m_isRunning;
    }

    @Override
    /**
     * This method attemps to disconnect and stop the device and connection.
     */
    public void stop() {
        if (m_socket != null) {
            disconnectedBroadcast
                    .putExtra(BluezService.EVENT_DISCONNECTED_ADDRESS,
                            getDeviceAddress());
            m_context.sendBroadcast(disconnectedBroadcast);

            try {
                m_socket.close();
            } catch (Exception ex) {
                notifyError(ex);
            }
        }

        m_isRunning = false;
        m_socket = null;
        m_input = null;

        if (m_foregroundServiceIntent != null && m_context != null) {
            m_foregroundServiceIntent
                    .setAction(BluezForegroundService.ACTION_STOP);
            m_context.startService(m_foregroundServiceIntent);
            m_foregroundServiceIntent = null;
        }
    }

    @Override
    /**
     * This method is used, I believe, to catch the input from the device and send it off
     * to wherever it needs to go.
     */
    public void run() {
        byte[] buffer = new byte[0x80];
        int read = 0;
        int errors = 0;

        int unparsed = 0;

        while (m_isRunning) {
            try {

                read = m_input.read(buffer, unparsed, buffer.length - unparsed);
                errors = 0;

                read += unparsed;
                unparsed = parseInputData(buffer, read);
                if (unparsed < 0)
                    unparsed = 0;

                if (unparsed >= buffer.length - 10) {

                    unparsed = 0;
                }

                // Copy the remaining data back to the beginning of the buffer
                // to emulate a sliding window buffer
                if (unparsed > 0 && read != unparsed) {

                    System.arraycopy(buffer, read - unparsed, buffer, 0,
                            unparsed);

                }

            } catch (Exception ex) {

                errors++;
                if (errors > 10) {
                    // Give up
                    notifyError(ex);
                    m_isRunning = false;
                } else if (errors > 1) {
                    // Retry after a little while
                    try {
                        Thread.sleep(100 * errors);
                    } catch (Exception e) {
                    }
                }
            }
        }

    }

    /**
     * This method parses the data received from the device and decides what to do with it.
     * 
     * @param data the data from the device to be parsed
     * @param read the amount of data?
     * @return the amount of data remaining?
     */
    protected abstract int parseInputData(byte[] data, int read);

    /**
     * This method produces error messages if things go wrong and stops the connection.
     * 
     * @param ex the exception that caused the problems
     */
    protected void notifyError(Exception ex) {
        Log.e(LOG_NAME + getDriverName(), ex.toString());

        errorBroadcast
                .putExtra(BluezService.EVENT_ERROR_SHORT, ex.getMessage());
        errorBroadcast.putExtra(BluezService.EVENT_ERROR_FULL, ex.toString());
        m_context.sendBroadcast(errorBroadcast);

        stop();
    }

    /**
     * Returns a hex value used for debugging and error reading I believe.
     * 
     * @param buffer
     * @param offset
     * @param count
     * @return
     */
    public static String getHexString(byte[] buffer, int offset, int count) {
        StringBuilder buf = new StringBuilder();
        for (int i = offset; i < count; i++) {
            if ((buffer[i] & 0xff) < 0x10)
                buf.append("0");
            buf.append(Integer.toHexString((buffer[i] & 0xff))).append(" ");
        }

        return buf.toString();
    }

}
