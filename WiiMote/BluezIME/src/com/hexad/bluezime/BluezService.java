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

import android.app.IntentService;
import android.bluetooth.BluetoothAdapter;
import android.content.Intent;
import android.content.pm.PackageManager.NameNotFoundException;
import android.os.Binder;
import android.os.IBinder;
import android.util.Log;

import java.util.Hashtable;

/**
 * This class is the actual service that shows up on the phone.
 * It is the presiding class that controls all the others?
 */
public class BluezService extends IntentService {

    public static final String[] DRIVER_NAMES = { WiimoteReader.DRIVER_NAME, };

    public static final String[] DRIVER_DISPLAYNAMES = { WiimoteReader.DISPLAY_NAME, };
    public static final String DEFAULT_DRIVER_NAME = DRIVER_NAMES[0];

    public static final String SESSION_ID = "com.hexad.bluezime.sessionid";
    public static final String DEFAULT_SESSION_NAME = "com.hexad.bluezime.default_session";

    public static final String EVENT_KEYPRESS = "com.hexad.bluezime.keypress";
    public static final String EVENT_KEYPRESS_KEY = "key";
    public static final String EVENT_KEYPRESS_ACTION = "action";
    public static final String EVENT_KEYPRESS_ANALOG_EMULATED = "emulated";

    public static final String EVENT_DIRECTIONALCHANGE = "com.hexad.bluezime.directionalchange";
    public static final String EVENT_DIRECTIONALCHANGE_DIRECTION = "direction";
    public static final String EVENT_DIRECTIONALCHANGE_VALUE = "value";

    public static final String EVENT_ACCELEROMETERCHANGE = 
        "com.hexad.bluezime.accelerometerchange";
    public static final String EVENT_ACCELEROMETERCHANGE_AXIS = "axis";
    public static final String EVENT_ACCELEROMETERCHANGE_VALUE = "value";

    public static final String EVENT_CONNECTING = "com.hexad.bluezime.connecting";
    public static final String EVENT_CONNECTING_ADDRESS = "address";

    public static final String EVENT_CONNECTED = "com.hexad.bluezime.connected";
    public static final String EVENT_CONNECTED_ADDRESS = "address";

    public static final String EVENT_DISCONNECTED = "com.hexad.bluezime.disconnected";
    public static final String EVENT_DISCONNECTED_ADDRESS = "address";

    public static final String EVENT_ERROR = "com.hexad.bluezime.error";
    public static final String EVENT_ERROR_SHORT = "message";
    public static final String EVENT_ERROR_FULL = "stacktrace";

    public static final String REQUEST_CONNECT = "com.hexad.bluezime.connect";
    public static final String REQUEST_CONNECT_ADDRESS = "address";
    public static final String REQUEST_CONNECT_DRIVER = "driver";
    public static final String REQUEST_CONNECT_USE_UI = "use-ui-setup";
    public static final String REQUEST_CONNECT_CREATE_NOTIFICATION = "registernotification";

    public static final String REQUEST_DISCONNECT = "com.hexad.bluezime.disconnect";

    public static final String REQUEST_STATE = "com.hexad.bluezime.getstate";

    public static final String EVENT_REPORTSTATE = "com.hexad.bluezime.currentstate";
    public static final String EVENT_REPORTSTATE_CONNECTED = "connected";
    public static final String EVENT_REPORTSTATE_DEVICENAME = "devicename";
    public static final String EVENT_REPORTSTATE_DISPLAYNAME = "displayname";
    public static final String EVENT_REPORTSTATE_DRIVERNAME = "drivername";

    // The service caller can also activate these, but they are not used by
    // Bluez-IME (=> Not tested!)
    public static final String REQUEST_FEATURECHANGE = "com.hexad.bluezime.featurechange";
    public static final String REQUEST_FEATURECHANGE_RUMBLE = "rumble"; // Boolean,
                                                                        // true=on,
                                                                        // false=off
    public static final String REQUEST_FEATURECHANGE_LEDID = "ledid"; // Integer,
                                                                      // LED to
                                                                      // use 1-4
                                                                      // for
                                                                      // Wiimote
    public static final String REQUEST_FEATURECHANGE_ACCELEROMETER = "accelerometer"; // Boolean,
                                                                                      // true=on,
                                                                                      // false=off

    public static final String REQUEST_CONFIG = "com.hexad.bluezime.getconfig";

    public static final String EVENT_REPORT_CONFIG = "com.hexad.bluezime.config";
    public static final String EVENT_REPORT_CONFIG_VERSION = "version";
    public static final String EVENT_REPORT_CONFIG_DRIVER_NAMES = "drivernames";
    public static final String EVENT_REPORT_CONFIG_DRIVER_DISPLAYNAMES = "driverdisplaynames";

    private static final String LOG_NAME = "BluezService";
    private final Binder binder = new LocalBinder();

    // private static BluezDriverInterface m_reader = null;
    private static Hashtable<String, BluezDriverInterface> m_readers = 
        new Hashtable<String, BluezDriverInterface>();

    /**
     * Doesn't do anymore than what the inherited version does.
     */
    public BluezService() {
        super(LOG_NAME);
    }

    @Override
    /**
     * Doesn't do anymore than what the inherited version does.
     */
    public void onCreate() {
        super.onCreate();
    }

    /**
     * This binder is for BluezService alone.
     */
    public class LocalBinder extends Binder {
        /**
         * This method returns the BluezService class.
         * 
         * @return returns the current instance of BluezService
         */
        BluezService getService() {
            return (BluezService.this);
        }
    }

    @Override
    /**
     * This method just returns whatever binder is currently being used.
     * 
     * @param intent whatever intent called this method, not used
     */
    public IBinder onBind(Intent intent) {
        return binder;
    }

    @Override
    /**
     * This method handles intents and does what it has to do with their varied requests
     * 
     * @param intent the various intents that can be applied
     */
    protected void onHandleIntent(Intent intent) {
        if (intent == null || intent.getAction() == null)
            return;

        String sessionId = DEFAULT_SESSION_NAME;
        if (intent.hasExtra(SESSION_ID))
            sessionId = intent.getStringExtra(SESSION_ID);

        BluezDriverInterface reader = null;
        synchronized (m_readers) {
            if (sessionId != null && m_readers.containsKey(sessionId))
                reader = m_readers.get(sessionId);
        }

        if (intent.getAction().equals(REQUEST_CONNECT)) {
            String address = null;
            String driver = null;

            if (intent.hasExtra(REQUEST_CONNECT_ADDRESS))
                address = intent.getStringExtra(REQUEST_CONNECT_ADDRESS);
            if (intent.hasExtra(REQUEST_CONNECT_DRIVER))
                driver = intent.getStringExtra(REQUEST_CONNECT_DRIVER);

            if (address == null || driver == null) {
                boolean use_ui = intent.getBooleanExtra(REQUEST_CONNECT_USE_UI,
                        false);
                Preferences p = new Preferences(this);

                if (address == null)
                    address = p.getSelectedDeviceAddress();
                if (driver == null)
                    driver = p.getSelectedDriverName();

                if (!use_ui) {
                    Log.w(LOG_NAME,
                            "No driver/address set for connect request, " +
                            "please update your application. " +
                            "If this is intentional, please set the option "
                                    + REQUEST_CONNECT_USE_UI + " to true");
                }
            }

            boolean startnotification = intent.getBooleanExtra(
                    REQUEST_CONNECT_CREATE_NOTIFICATION, true);
            connectToDevice(address, driver, sessionId, startnotification);
        } else if (intent.getAction().equals(REQUEST_DISCONNECT)) {
            disconnectFromDevice(sessionId);
        } else if (intent.getAction().equals(REQUEST_FEATURECHANGE)) {
            try {
                // NOTE: Not tested!

                if (intent.hasExtra(REQUEST_FEATURECHANGE_RUMBLE)) {
                    if (reader != null && reader instanceof WiimoteReader) {
                        ((WiimoteReader) reader).request_SetRumble(intent
                                .getBooleanExtra(REQUEST_FEATURECHANGE_RUMBLE,
                                        false));
                    }
                }

                if (intent.hasExtra(REQUEST_FEATURECHANGE_ACCELEROMETER)) {
                    if (reader != null && reader instanceof WiimoteReader) {
                        ((WiimoteReader) reader)
                                .request_UseAccelerometer(intent
                                        .getBooleanExtra(
                                                REQUEST_FEATURECHANGE_ACCELEROMETER,
                                                false));
                    }
                }

                if (intent.hasExtra(REQUEST_FEATURECHANGE_LEDID)) {
                    if (reader != null && reader instanceof WiimoteReader) {
                        int led = intent.getIntExtra(
                                REQUEST_FEATURECHANGE_LEDID, 1);
                        ((WiimoteReader) reader).request_SetLEDState(led == 1,
                                led == 2, led == 3, led == 4);
                    }
                }
            } catch (Exception ex) {
                notifyError(ex, sessionId);
            }
        } else if (intent.getAction().equals(REQUEST_STATE)) {
            Intent i = new Intent(EVENT_REPORTSTATE);

            synchronized (this) {
                i.putExtra(EVENT_REPORTSTATE_CONNECTED, reader != null);
                i.putExtra(SESSION_ID, sessionId);
                if (reader != null) {
                    i.putExtra(EVENT_REPORTSTATE_DEVICENAME,
                            reader.getDeviceAddress());
                    i.putExtra(EVENT_REPORTSTATE_DISPLAYNAME,
                            reader.getDeviceName());
                    i.putExtra(EVENT_REPORTSTATE_DRIVERNAME,
                            reader.getDriverName());
                }
            }

            sendBroadcast(i);
        } else if (intent.getAction().equals(REQUEST_CONFIG)) {
            Intent i = new Intent(EVENT_REPORT_CONFIG);

            int version = 0;
            try {
                version = this.getPackageManager().getPackageInfo(
                        this.getPackageName(), 0).versionCode;
            } catch (NameNotFoundException e) {
                Log.w(LOG_NAME, e.getMessage());
            }

            i.putExtra(SESSION_ID, sessionId);
            i.putExtra(EVENT_REPORT_CONFIG_VERSION, version);
            i.putExtra(EVENT_REPORT_CONFIG_DRIVER_NAMES,
                    BluezService.DRIVER_NAMES);
            i.putExtra(EVENT_REPORT_CONFIG_DRIVER_DISPLAYNAMES,
                    BluezService.DRIVER_DISPLAYNAMES);

            sendBroadcast(i);
        } else {
            notifyError(
                    new Exception(
                            this.getString(R.string.bluetooth_unsupported)),
                    sessionId);
        }
    }

    /**
     * This method disconnects the device.
     * 
     * @param sessionId an ID for loggind and notifying uses
     */
    private synchronized void disconnectFromDevice(String sessionId) {
        String adr = "<null>";
        try {
            BluezDriverInterface reader = null;
            synchronized (m_readers) {
                if (sessionId != null && m_readers.containsKey(sessionId))
                    reader = m_readers.get(sessionId);
            }

            if (reader != null) {
                adr = reader.getDeviceAddress();
                reader.stop();
            }
        } catch (Exception ex) {
            Log.e(LOG_NAME, "Error on disconnect from " + adr + ", message: "
                    + ex.toString());
            notifyError(ex, sessionId);
        } finally {
            synchronized (m_readers) {
                if (sessionId != null && m_readers.containsKey(sessionId))
                    m_readers.remove(sessionId);
            }
        }
    }

    /**
     * This method connects to the device.
     * 
     * @param address The device's address
     * @param driver The current driver specified
     * @param sessionId an ID for loggind and notifying purposes
     * @param startnotification whether to notify the phone
     */
    private synchronized void connectToDevice(String address, String driver,
            String sessionId, boolean startnotification) {
        try {
            if (address == null || address.trim().length() == 0)
                throw new Exception("Invalid call, no address specified");
            if (driver == null || driver.trim().length() == 0)
                throw new Exception("Invalid call, no driver specified");
            if (sessionId == null || sessionId.trim().length() == 0)
                throw new Exception("Invalid call, no session id specified");

            BluetoothAdapter blue = BluetoothAdapter.getDefaultAdapter();
            if (blue == null)
                throw new Exception(
                        this.getString(R.string.bluetooth_unsupported));
            if (!blue.isEnabled())
                throw new Exception(
                        this.getString(R.string.error_bluetooth_off));

            BluezDriverInterface reader = null;

            synchronized (m_readers) {
                if (sessionId != null && m_readers.containsKey(sessionId))
                    reader = m_readers.get(sessionId);

                if (reader != null) {
                    if (reader.isRunning()
                            && address.equals(reader.getDeviceAddress())
                            && driver.toLowerCase().equals(
                                    reader.getDriverName()))
                        return; // Already connected

                    // Connect to other device, disconnect
                    disconnectFromDevice(sessionId);
                }

                Intent connectingBroadcast = new Intent(EVENT_CONNECTING);
                connectingBroadcast.putExtra(EVENT_CONNECTING_ADDRESS, address);
                connectingBroadcast.putExtra(SESSION_ID, sessionId);
                sendBroadcast(connectingBroadcast);

                if (driver.toLowerCase().equals(
                        WiimoteReader.DRIVER_NAME.toLowerCase()))
                    reader = new WiimoteReader(address, sessionId,
                            getApplicationContext(), startnotification);
                else
                    throw new Exception(String.format(
                            this.getString(R.string.invalid_driver), driver));

                m_readers.put(sessionId, reader);
            }

            new Thread(reader).start();
        } catch (Exception ex) {
            notifyError(ex, sessionId);
        }
    }

    /**
     * This method broadcasts errors if things go wrong.
     * 
     * @param ex The exception to be broadcast
     * @param sessionId The current ID for logging and notifying purposes
     */
    private void notifyError(Exception ex, String sessionId) {
        Log.e(LOG_NAME, ex.toString());

        Intent errorBroadcast = new Intent(EVENT_ERROR);
        errorBroadcast.putExtra(EVENT_ERROR_SHORT, ex.getMessage());
        errorBroadcast.putExtra(EVENT_ERROR_FULL, ex.toString());
        errorBroadcast.putExtra(SESSION_ID, sessionId);
        sendBroadcast(errorBroadcast);

        disconnectFromDevice(sessionId);
    }
}
