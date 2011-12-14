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
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301  USA
 */
package com.hexad.bluezime;

import android.content.Context;
import android.util.Log;
import android.view.KeyEvent;

import java.io.IOException;
import java.util.Hashtable;

/**
 * Handles the interactionsb between the wiimote and the phone. For VirPong in
 * particular, it turns the acceleration in the x-axis of the Wiimote into
 * simulated keypress on the android phone.
 */
public class WiimoteReader extends HIDReaderBase {

    public static final String DRIVER_NAME = "wiimote";

    public static final String DISPLAY_NAME = "Wiimote (some firmwares)";

    public static final int KEYCODE_BUTTON_A = 0x60;
    public static final int KEYCODE_BUTTON_B = 0x61;
    public static final int KEYCODE_BUTTON_X = 0x63;
    public static final int KEYCODE_BUTTON_Y = 0x64;
    public static final int KEYCODE_BUTTON_L1 = 0x66;
    public static final int KEYCODE_BUTTON_R1 = 0x67;
    public static final int KEYCODE_BUTTON_L2 = 0x68;
    public static final int KEYCODE_BUTTON_R2 = 0x69;
    public static final int KEYCODE_BUTTON_START = 0x6c;
    public static final int KEYCODE_BUTTON_SELECT = 0x6d;

    // Value for keys we do not care about
    public static final int KEYCODE_UNUSED = 0x0;

    // Accelerometer axis (x,y,z) is reported as accelerometer (0,1,2)
    private static final int CORE_ACCELEROMETER_AXIS_OFFSET = 0;

    // Nunchuck accelerometer axis (x,y,z) is reported as accelerometer (3,4,5)
    private static final int NUNCHUCK_ACCELEROMETER_AXIS_OFFSET = 3;

    // Mappings from bit-index to keycode for core buttons
    private static final int[] CORE_KEYS = new int[] { 
            KeyEvent.KEYCODE_S, // Byte 1, bit 0 button 2
            KeyEvent.KEYCODE_W, // Byte 1, bit 1 button 1
            KeyEvent.KEYCODE_S, // Byte 1, bit 2 button B
            KeyEvent.KEYCODE_W, // Byte 1, bit 3 button A
            KeyEvent.KEYCODE_S, // Byte 1, bit 4 button Minus
            KEYCODE_UNUSED, // Byte 1, bit 5
            KEYCODE_UNUSED, // Byte 1, bit 6
            KeyEvent.KEYCODE_H, // Byte 1, bit 7
            KeyEvent.KEYCODE_S, // Byte 0, bit 0 button left
            KeyEvent.KEYCODE_W, // Byte 0, bit 1 button right
            KeyEvent.KEYCODE_S, // Byte 0, bit 2 button down
            KeyEvent.KEYCODE_W, // Byte 0, bit 3 button up
            KeyEvent.KEYCODE_W, // Byte 0, bit 4 button Plus
            KEYCODE_UNUSED, // Byte 0, bit 5
            KEYCODE_UNUSED, // Byte 0, bit 6
            KEYCODE_UNUSED, // Byte 0, bit 7
    };

    // Mappings from bit-index to keycode for classic keys
    private static final int[] CLASSIC_KEYS = new int[] { 
            KEYCODE_UNUSED, // Byte 4, bit 0
            KEYCODE_BUTTON_R2, // Byte 4, bit 1
            KeyEvent.KEYCODE_PLUS, // Byte 4, bit 2
            KeyEvent.KEYCODE_H, // Byte 4, bit 3
            KeyEvent.KEYCODE_MINUS, // Byte 4, bit 4
            KEYCODE_BUTTON_L2, // Byte 4, bit 5
            KeyEvent.KEYCODE_DPAD_DOWN, // Byte 4, bit 6
            KeyEvent.KEYCODE_DPAD_RIGHT, // Byte 4, bit 7
            KeyEvent.KEYCODE_DPAD_UP, // Byte 5, bit 0
            KeyEvent.KEYCODE_DPAD_LEFT, // Byte 5, bit 1
            KEYCODE_BUTTON_R1, // Byte 5, bit 2
            KEYCODE_BUTTON_X, // Byte 5, bit 3
            KEYCODE_BUTTON_A, // Byte 5, bit 4
            KEYCODE_BUTTON_Y, // Byte 5, bit 5
            KEYCODE_BUTTON_B, // Byte 5, bit 6
            KEYCODE_BUTTON_L1, // Byte 5, bit 7
    };

    // Mappings for Nunchuck buttons
    private static final int[] NUNCHUCK_KEYS = new int[] { 
            KeyEvent.KEYCODE_C, // C Button
            KeyEvent.KEYCODE_Z, // Z Button
    };

    // Emulated keypress values for core accelerometer
    private static final int[] CORE_ACCELEROMETER_KEYS = new int[] {
            KeyEvent.KEYCODE_W, // Accelerometer X up
            KeyEvent.KEYCODE_S, // Accelerometer X down
            // KeyEvent.KEYCODE_W, //Accelerometer Y up
            // KeyEvent.KEYCODE_S, //Accelerometer Y down
            // KeyEvent.KEYCODE_W, //Accelerometer Z up
            // KeyEvent.KEYCODE_S, //Accelerometer Z down
            KeyEvent.KEYCODE_UNKNOWN, KeyEvent.KEYCODE_UNKNOWN,
            KeyEvent.KEYCODE_UNKNOWN, KeyEvent.KEYCODE_UNKNOWN };

    // Emulated keypress values for classic thumbsticks
    private static final int[] CLASSIC_ANALOG_KEYS = new int[] {
            KeyEvent.KEYCODE_D, // Classic, Left stick right
            KeyEvent.KEYCODE_Q, // Classic, Left stick left
            KeyEvent.KEYCODE_W, // Classic, Left stick up
            KeyEvent.KEYCODE_S, // Classic, Left stick down
            KeyEvent.KEYCODE_6, // Classic, Right stick right
            KeyEvent.KEYCODE_4, // Classic, Right stick left
            KeyEvent.KEYCODE_8, // Classic, Right stick up
            KeyEvent.KEYCODE_5, // Classic, Right stick down
            KEYCODE_UNUSED, // Classic, L2 up
            KEYCODE_UNUSED, // Classic, L2 down
            KEYCODE_UNUSED, // Classic, R2 up
            KEYCODE_UNUSED, // Classic, R2 down
    };

    // Emulated keypress values for nunchuck accelerometer
    private static final int[] NUNCHUCK_ACCELEROMETER_KEYS = new int[] {
            KeyEvent.KEYCODE_V, // Nunchuck, Accelerometer X up
            KeyEvent.KEYCODE_B, // Nunchuck, Accelerometer X down
            KeyEvent.KEYCODE_G, // Nunchuck, Accelerometer Y up
            KeyEvent.KEYCODE_H, // Nunchuck, Accelerometer Y down
            KeyEvent.KEYCODE_Y, // Nunchuck, Accelerometer Z up
            KeyEvent.KEYCODE_U, // Nunchuck, Accelerometer Z down
    };

    // Emulated keypress values for nunchuck thumbsticks
    private static final int[] NUNCHUCK_ANALOG_KEYS = new int[] {
            KeyEvent.KEYCODE_D, // Nunchuck, Thumbstick right
            KeyEvent.KEYCODE_Q, // Nunchuck, Thumbstick left
            KeyEvent.KEYCODE_S, // Nunchuck, Thumbstick down
            KeyEvent.KEYCODE_W, // Nunchuck, Thumbstick up
    };

    // The ID for a Wii Classic Controller
    private static final byte[] CLASSIC_DEVICE_ID = new byte[] { 0x00, 0x00,
            (byte) 0xA4, 0x20, 0x01, 0x01 };

    // The ID for a Wii Classic Controller (not documented, but reported)
    private static final byte[] CLASSIC_DEVICE_ID_ALT = new byte[] { 0x01,
            0x00, (byte) 0xA4, 0x20, 0x01, 0x01 };

    // The ID for a Wii Nunchuck Controller
    private static final byte[] NUNCHUCK_DEVICE_ID = new byte[] { 0x00, 0x00,
            (byte) 0xA4, 0x20, 0x00, 0x00 };

    // The ID for a Wii Nunchuck Controller (not documented, but reported)
    private static final byte[] NUNCHUCK_DEVICE_ID_ALT = new byte[] {
            (byte) 0xFF, 0x00, (byte) 0xA4, 0x20, 0x00, 0x00 };

    // Enumeration for states required for extension initialization
    private static final int EXTENSION_INIT_STATE_NONE = 0;
    private static final int EXTENSION_INIT_STATE_SENT_FIRST = 1;
    private static final int EXTENSION_INIT_STATE_SENT_SECOND = 2;
    private static final int EXTENSION_INIT_STATE_SENT_READ = 3;

    // Offsets into the control messages
    private static int EXTENSION_ADR_OFFSET = 5;
    private static int EXTENSION_VAL_OFFSET = 7;
    private static int REPORTMODE_OFFSET = 3;
    private static int SET_LED_OFFSET = 2;

    // Command for writing an extension command, kept here to avoid allocations
    private byte[] m_extensionWriteData = new byte[] { 0x52, 0x16, 0x04,
            (byte) 0xA4, 0x00, 0x00, 0x01, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
            0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00 };

    // Command for reading extension data, kept here to avoid allocations
    private byte[] m_extensionReadData = new byte[] { 0x52, 0x17, 0x04,
            (byte) 0xA4, 0x00, 0x00, 0x00, 0x00 };

    // The command used to request status, kept here to avoid allocations
    private final byte[] m_requestStatus = new byte[] { 0x52, 0x15, 0x00 };

    // The command used to request status, kept here to avoid allocations
    private final byte[] m_setLedStatus = new byte[] { 0x52, 0x11, 0x00 };

    // The command used to set report mode, kept here to avoid allocations
    private byte[] m_setReportMode = new byte[] { 0x52, 0x12, 0x00, 0x00 };

    // A buffer for reading memory data, kept here to avoid allocations
    private byte[] m_memoryDataBuffer = new byte[16];

    // A flag that tells if the Wii Classic Controller is connected
    private boolean m_isClassicConnected = false;

    // A flag that tells if the Wii Nunchuck Controller is connected
    private boolean m_isNunchuckConnected = false;

    // A state counter, used to keep track of states in the extension
    // initialization sequence
    private int m_extensionInitState = EXTENSION_INIT_STATE_NONE;

    // The state of all core buttons, 1 means down, 0 means up
    private int[] m_coreButtons = new int[16];

    // The core accelerometer values for x,y,z
    private int[] m_coreAccelerometerValues = new int[3];

    // State of emulated direction keys for core accelerometer
    private boolean[] m_coreEmulatedAccelerometerButtons 
            = new boolean[m_coreAccelerometerValues.length * 2];

    // The state of all classic controller buttons, 1 means down, 0 means up
    private int[] m_classicButtons = new int[16];

    // The analog values from the classic controller thumbsticks
    private int[] m_classicAnalogValues = new int[6];

    // State of emulated direction keys for classic controller thumbsticks
    private boolean[] m_classicEmulatedButtons 
            = new boolean[m_classicAnalogValues.length * 2];

    // The accelerometer values for x,y,z
    private int[] m_nunchuckAccelerometerValues = new int[3];

    // The analog values for the nunchuck thumbstick
    private int[] m_nunchuckAnalogValues = new int[2];

    // State of emulated direction keys for nunchuck accelerometer
    private boolean[] m_nunchuckEmulatedAccelerometerButtons 
            = new boolean[m_nunchuckAccelerometerValues.length * 2];

    // State of emulated direction keys for nunchuck thumbstick
    private boolean[] m_nunchuckEmulatedButtons 
            = new boolean[m_nunchuckAnalogValues.length * 2];

    // The state of the nunchuck buttons
    private boolean[] m_nunchuckButtons = new boolean[2];

    // A temporary holder for analog values
    private int[] m_tmpAnalogValues = new int[16];

    // A flag that keeps the rumble state
    private boolean m_rumbleOn = false;

    // The state of the LEDs
    private byte m_LedState = 0x10;

    // A flag indicating if the accelerometer is active
    private boolean m_useAccelerometer = true;

    // A flag that indicates an update needs to be performed,
    // This flag reduces the number of times a synchronized method is called
    private volatile boolean m_dirtyUpdateFlag;

    // The variables keep an intent to change, and are processed in synchronized
    // methods
    private boolean m_updateRequestRumble = m_rumbleOn;
    private byte m_updateRequestLEDState = m_LedState;
    private boolean m_updateRequestAccelerometer = m_useAccelerometer;

    // Keeps track of the 'position' moved around by the acceleration from the accelerometer
    private double[] m_position = new double[3];
    // Keeps track of the last rounded position for VirPong purposes
    private long[] m_roundedPosition = new long[3];
    // Scales the acceleration from the accelerometer to keep the positions smaller.
    private static double SCALAR = .004;

    @Override
    /**
     * This method returns the supported report codes of this reader.
     * 
     * @return whatever codes are supported
     */
    protected Hashtable<Byte, Integer> getSupportedReportCodes() {

        Hashtable<Byte, Integer> results = new Hashtable<Byte, Integer>();

        results.put((byte) 0x20, 6); // Status information
        results.put((byte) 0x21, 21); // Read register data
        results.put((byte) 0x22, 4); // Acknowledge report

        // Data reports
        results.put((byte) 0x30, 2);
        results.put((byte) 0x31, 5);
        results.put((byte) 0x32, 10);
        results.put((byte) 0x33, 17);
        results.put((byte) 0x34, 21);
        results.put((byte) 0x35, 21);
        results.put((byte) 0x36, 21);
        results.put((byte) 0x37, 21);
        results.put((byte) 0x3d, 21);

        return results;
    }

    /**
     * Very simple constructor, calls up to the constructor for RfcommReader.
     * 
     * @param address used in RfcommReader
     * @param sessionId used in RfcommReader
     * @param context used in RfcommReader
     * @param startnotification used in RfcommReader
     * @throws Exception in case anything goes wrong
     */
    public WiimoteReader(String address, String sessionId, Context context,
            boolean startnotification) throws Exception {
        super(address, sessionId, context, startnotification);

        super.doConnect();
    }

    @Override
    public String getDriverName() {
        return DRIVER_NAME;
    }

    @Override
    protected void verifyHIDDevice() throws Exception {
        // When this is called, we are connected,
        // so we set up the current state

        // Set the LEDs to indicate we are now connected
        setLEDs(true, true, false, true);

        // Set the report mode
        updateReportMode();

        // Request a status report so we detect extensions immediately
        requestStatus();
    }

    @Override
    protected void handleHIDMessage(byte hidType, byte reportId, byte[] data)
            throws Exception {
        // if (D2) Log.d(DRIVER_NAME, "Got Wii message " + reportId + ": " +
        // getHexString(data, 0, data.length));

        // Core buttons are always present in the status reports
        handleCoreButtons(data[0], data[1]);

        // If the accelerometer is active, we handle it here
        if (m_useAccelerometer) {
            switch (reportId) {
            case (byte) 0x31: // Core buttons + accelerometer
            case (byte) 0x33: // Core buttons + accelerometer + 12 IR bytes
            case (byte) 0x35: // Core buttons + accelerometer + 16 extension
                              // bytes
            case (byte) 0x37: // Core buttons + accelerometer + 10 IR bytes + 6
                              // extension bytes
                handleAccelerometerData(data[2], data[3], data[4]);
                break;
            }
        }

        switch (reportId) {
        case (byte) 0x20: // Status report
            handleStatusReport(data[2], data[5]);
            break;
        case (byte) 0x21: // Read memory data
            if ((data[2] & 0xf) != 0) {
                // if (D) Log.e(DRIVER_NAME, "Failed to read extension type");
                m_extensionInitState = EXTENSION_INIT_STATE_NONE;
            } else {
                byte size = (byte) ((data[2] >>> 4) + 1);
                int dataoffset = (data[3] << 8) | (((int) data[4]) & 0xff);
                System.arraycopy(data, 5, m_memoryDataBuffer, 0, size);
                handleExtensionDataRead(dataoffset, size, m_memoryDataBuffer);
            }
            break;
        case (byte) 0x22: // Acknowledge report
            handleAcknowledgeReport(data[2], data[3]);
            break;
        case (byte) 0x32: // Core buttons + 8 extension bytes
            handleExtensionData(data, 2);
            break;
        case (byte) 0x34: // Core buttons + 19 extension bytes
            handleExtensionData(data, 4);
            break;
        case (byte) 0x35: // Core buttons + accelerometer + 16 extension bytes
            handleExtensionData(data, 5);
            break;
        case (byte) 0x36: // Core buttons + 10 IR bytes + 9 extension bytes
            handleExtensionData(data, 12);
            break;
        case (byte) 0x37: // Core buttons + accelerometer + 10 IR bytes + 6
                          // extension bytes
            handleExtensionData(data, 15);
            break;

        case (byte) 0x30: // Core buttons
        case (byte) 0x31: // Core buttons + accelerometer
        case (byte) 0x33: // Core buttons + accelerometer + 12 IR bytes
            // Do not report any unexpected message for these
            break;

        default:
            break;
        }

        // We only call the synchronized method when the flag is set
        // which reduces the number of times we need to obtain the lock
        if (m_dirtyUpdateFlag)
            processUpdateRequest();
    }

    /**
     * Determines whether there are any addons to the wiimote and sets the
     * proper fields to their proper values for those addons...
     * 
     * @param offset Seems to just be there it check for improper values
     * @param size The length of the data that determines addons
     * @param data The data itself that will determine addons
     * @throws IOException If it happens that something goes horribly wrong
     */
    private void handleExtensionDataRead(int offset, byte size, byte[] data)
            throws IOException {

        if (offset != 0x00fa || size != CLASSIC_DEVICE_ID.length) {
            Log.e(DRIVER_NAME,
                    "Unexpected data read: " + getHexString(data, 0, size));
        } else if (m_extensionInitState != EXTENSION_INIT_STATE_SENT_READ) {
            Log.e(DRIVER_NAME, "Got extension data but state was: "
                    + m_extensionInitState);
        } else {

            m_extensionInitState = EXTENSION_INIT_STATE_NONE;
            boolean classic = true;
            for (int i = 0; i < size; i++)
                classic &= data[i] == CLASSIC_DEVICE_ID[i];

            boolean classic_alt = true;
            for (int i = 0; i < size; i++)
                classic_alt &= data[i] == CLASSIC_DEVICE_ID_ALT[i];

            boolean nunchuck = true;
            for (int i = 0; i < size; i++)
                nunchuck &= data[i] == NUNCHUCK_DEVICE_ID[i];

            boolean nunchuck_alt = true;
            for (int i = 0; i < size; i++)
                nunchuck_alt &= data[i] == NUNCHUCK_DEVICE_ID_ALT[i];

            if (classic || classic_alt) {

                // Clear any previous states
                for (int i = 0; i < m_classicButtons.length; i++)
                    m_classicButtons[i] = 0;
                for (int i = 0; i < m_classicAnalogValues.length; i++)
                    m_classicAnalogValues[i] = 0;
                for (int i = 0; i < m_classicEmulatedButtons.length; i++)
                    m_classicEmulatedButtons[i] = false;

                m_isClassicConnected = true;
                updateReportMode();
            } else if (nunchuck | nunchuck_alt) {

                // Clear any previous states
                for (int i = 0; i < m_nunchuckButtons.length; i++)
                    m_nunchuckButtons[i] = false;
                for (int i = 0; i < m_nunchuckAccelerometerValues.length; i++)
                    m_nunchuckAccelerometerValues[i] = 0;
                for (int i = 0; i < m_nunchuckAnalogValues.length; i++)
                    m_nunchuckAnalogValues[i] = 0;
                for (int i = 0; i < m_nunchuckEmulatedAccelerometerButtons.length; i++)
                    m_nunchuckEmulatedAccelerometerButtons[i] = false;
                for (int i = 0; i < m_nunchuckEmulatedButtons.length; i++)
                    m_nunchuckEmulatedButtons[i] = false;

                m_isNunchuckConnected = true;
                updateReportMode();
            } else {
                Log.d(DRIVER_NAME, "Unknown extension device id: "
                        + getHexString(data, 0, size));
            }
        }
    }

    /**
     * A thread-safe way to set the wiimote's LEDs. Is only sent when a report
     * is sent to the wiimote which may cause a delay.
     * 
     * @param l1 the first LED
     * @param l2 the second LED
     * @param l3 the third LED
     * @param l4 the fourth LED
     */
    public synchronized void request_SetLEDState(boolean l1, boolean l2,
            boolean l3, boolean l4) {
        m_dirtyUpdateFlag = true;
        m_updateRequestLEDState = (byte) ((l1 ? 0x10 : 0x00)
                | (l2 ? 0x20 : 0x00) | (l3 ? 0x40 : 0x00) | (l4 ? 0x80 : 0x00));
    }

    /**
     * A thread-safe way to enable the wiimote's rumble feature. Is only sent
     * when a report is sent to the wiimote which may cause a delay.
     * 
     * @param active
     *            the desired state of the rumble
     */
    public synchronized void request_SetRumble(boolean active) {
        m_dirtyUpdateFlag = true;
        m_updateRequestRumble = active;
    }

    /**
     * A thread-safe way to enable the wiimote's accelerometer. Is only sent
     * when a report is sent to the wiimote which may cause a delay.
     * 
     * @param active
     *            the desired state of the accelerometer
     */
    public synchronized void request_UseAccelerometer(boolean active) {
        m_dirtyUpdateFlag = true;
        m_updateRequestAccelerometer = active;
    }

    /**
     * "This method is called when the volatile update flag is set, and
     * processes all pending updates"
     */
    private synchronized void processUpdateRequest() throws Exception {
        m_dirtyUpdateFlag = false;

        if (m_LedState != m_updateRequestLEDState
                || m_rumbleOn != m_updateRequestRumble) {
            m_LedState = m_updateRequestLEDState;
            m_rumbleOn = m_updateRequestRumble;

            updateLEDStates();
        }

        if (m_useAccelerometer != m_updateRequestAccelerometer) {
            m_useAccelerometer = m_updateRequestAccelerometer;

            setAccelerometerActive(m_useAccelerometer);
        }
    }

    /**
     * An alternate way to set the LED's, not thread-safe.
     * 
     * @param l1 the first LED
     * @param l2 the second LED
     * @param l3 the third LED
     * @param l4 the fourth LED
     * @throws Exception probably if there is a problem with threading.
     */
    private void setLEDs(boolean l1, boolean l2, boolean l3, boolean l4)
            throws Exception {
        m_LedState = (byte) ((l1 ? 0x10 : 0x00) | (l2 ? 0x20 : 0x00)
                | (l3 ? 0x40 : 0x00) | (l4 ? 0x80 : 0x00));

        updateLEDStates();
    }

    /**
     * An alternate way to enable the accelerometer, not thread-safe.
     * 
     * @param active the desired state for the accelerometer
     * @throws IOException probably if there is a problem with threading.
     */
    private void setAccelerometerActive(boolean active) throws IOException {
        if (active != m_useAccelerometer) {
            m_useAccelerometer = active;

            if (m_useAccelerometer) {

                // Reset data
                for (int i = 0; i < m_coreAccelerometerValues.length; i++)
                    m_coreAccelerometerValues[i] = 0;
                for (int i = 0; i < m_coreEmulatedAccelerometerButtons.length; i++)
                    m_coreEmulatedAccelerometerButtons[i] = false;

                if (m_isNunchuckConnected) {
                    for (int i = 0; i < m_nunchuckEmulatedAccelerometerButtons.length; i++)
                        m_nunchuckEmulatedAccelerometerButtons[i] = false;
                    for (int i = 0; i < m_nunchuckAccelerometerValues.length; i++)
                        m_nunchuckAccelerometerValues[i] = 0;
                }
            }
            
            updateReportMode();
        }
    }

    //TODO: not used anywhere, but could be and thus should be left in
    @SuppressWarnings("unused")
    /**
     * An alternate way to enable/disable the rumble, not thread-safe.
     * 
     * @param rumbleON the desired state of the rumble function
     * @throws Exception probably if there is a problem with threading.
     */
    private void setRumble(boolean rumbleOn) throws Exception {
        m_rumbleOn = rumbleOn;

        updateLEDStates();
    }

    /**
     * Forces an update to the state of the LEDs on the wiimote. May cause
     * problems with threading. A thread-safe version exists.
     * 
     * @throws IOException probably if there is a problem with threading.
     */
    private void updateLEDStates() throws IOException {
        m_setLedStatus[SET_LED_OFFSET] = (byte) ((m_LedState & 0xf0) | (m_rumbleOn ? 0x01
                : 0x00));
        m_control.write(m_setLedStatus);
        m_control.flush();
    }

    /**
     * Forces a request to the wiimote? May cause portions like LEDs and rumble
     * and accelerometer to update their state.
     * 
     * @throws IOException might be thrown if there are threading issues
     */
    private void requestStatus() throws IOException {
        m_control.write(m_requestStatus);
        m_control.flush();
    }

    /**
     * I don't really know what this method does. Something to do with reports
     * to the wiimote and it's based on what attachments are on the wiimote.
     * 
     * @throws IOException if bad things happen in the midst of execution
     */
    private void updateReportMode() throws IOException {
        byte mode;

        if (m_isClassicConnected || m_isNunchuckConnected)
            mode = (byte) (m_useAccelerometer ? 0x35 : 0x32);
        else
            mode = (byte) (m_useAccelerometer ? 0x31 : 0x30);

        m_setReportMode[REPORTMODE_OFFSET] = mode;
        m_control.write(m_setReportMode);
        m_control.flush();
    }

    /**
     * I have no idea what this method does but I suggest it is left as is.
     * 
     * @param address
     * @param value
     * @throws IOException
     */
    private void writeExtensionRegister(byte address, byte value)
            throws IOException {
        m_extensionWriteData[EXTENSION_ADR_OFFSET] = address;
        m_extensionWriteData[EXTENSION_VAL_OFFSET] = value;

        m_control.write(m_extensionWriteData);
        m_control.flush();
    }

    /**
     * Almost the same as writeExtensionRegister... but uses size as opposed to
     * value.
     * 
     * @param address
     * @param size
     * @throws IOException
     */
    private void readExtensionRegisters(byte address, byte size)
            throws IOException {
        m_extensionReadData[EXTENSION_ADR_OFFSET] = address;
        m_extensionReadData[EXTENSION_VAL_OFFSET] = size;

        m_control.write(m_extensionReadData);
        m_control.flush();
    }

    /**
     * Uses the ExtensionRegister methods, but I don't know why or how
     * 
     * @param reportId
     * @param result
     * @throws IOException
     */
    private void handleAcknowledgeReport(byte reportId, byte result)
            throws IOException {

        if (reportId == 0x16) {

            if (result != 0x0) {
                Log.w(DRIVER_NAME, "Got NACK for write register report");
            }

            switch (m_extensionInitState) {
            case EXTENSION_INIT_STATE_SENT_FIRST:
                // Confirm extension initialization
                writeExtensionRegister((byte) 0xfb, (byte) 0x00);
                m_extensionInitState = EXTENSION_INIT_STATE_SENT_SECOND;
                break;
            case EXTENSION_INIT_STATE_SENT_SECOND:
                // This will read the extension device ID
                readExtensionRegisters((byte) 0xfa, (byte) 0x6);
                m_extensionInitState = EXTENSION_INIT_STATE_SENT_READ;
                break;
            }
        }
    }

    /**
     * I don't know what this method does. Appears to look at what attachments
     * are on the wiimote though.
     * 
     * @param state
     * @param voltage
     * @throws IOException
     */
    private void handleStatusReport(byte state, byte voltage)
            throws IOException {
        // boolean batteryNearlyDone = (state & 0x1) != 0;
        boolean extensionConnected = (state & 0x2) != 0;
        // boolean speakerEnabled = (state & 0x4) != 0;
        // boolean irEnabled = (state & 0x8) != 0;

        // If we have an extension connection change, examine it
        if (extensionConnected != (m_isClassicConnected || m_isNunchuckConnected)) {

            // If a new extension is connected, examine it to see what type it
            // is
            if (extensionConnected) {

                // These will activate the extension without encryption
                writeExtensionRegister((byte) 0xf0, (byte) 0x55);
                m_extensionInitState = EXTENSION_INIT_STATE_SENT_FIRST;
            } else {

                m_isClassicConnected = false;
                m_isNunchuckConnected = false;

                // Disable extension data
                updateReportMode();
            }
        }
    }

    /**
     * This method handles the values passed by the wiimote that relate to the
     * buttons on the wiimote not including the directional-pad. Turns the
     * buttons into virtual keypresses on the android keyboard.
     * 
     * 
     * @param bitmask no idea
     * @param states whether the button is pressed
     * @param keys the specific button being handled
     */
    private void handleDigitalButtons(int bitmask, int[] states, int[] keys) {
        for (int i = 0; i < 16; i++) {
            if ((bitmask & 1) != states[i]) {
                states[i] = (bitmask & 1);

                if (keys[i] != KEYCODE_UNUSED) {

                    keypressBroadcast.putExtra(
                            BluezService.EVENT_KEYPRESS_ACTION,
                            states[i] == 1 ? KeyEvent.ACTION_DOWN
                                    : KeyEvent.ACTION_UP);
                    keypressBroadcast.putExtra(BluezService.EVENT_KEYPRESS_KEY,
                            keys[i]);
                    keypressBroadcast.putExtra(
                            BluezService.EVENT_KEYPRESS_ANALOG_EMULATED, false);
                    m_context.sendBroadcast(keypressBroadcast);
                }
            }
            bitmask = bitmask >>> 1;
        }
    }

    /**
     * This method handles the values passed by the wiimote that relate to the
     * accelerometer and the directional-pad. Turns acceleration or d-pad pushes
     * into virtual keypresses on the android keyboard.
     * 
     * @param newValues the current state of the axis or direction
     * @param prev the previous state of the axis or direction
     * @param buttonstates whether the virtual key is being pressed already
     * @param keys the virtual key that relates to the wiimote part
     * @param report_axis_offset an offset since the accelerometer doesn't start at 0?
     * @param isAccelerometer whether the values being pressed are from the accelerometer
     */
    private void handleAnalogValues(int[] newValues, int[] prev,
            boolean[] buttonstates, int[] keys, int report_axis_offset,
            boolean isAccelerometer) {

        for (int i = 0; i < prev.length; i++) {
            // Make sure the values are always in range
            newValues[i] = Math.max(-127, Math.min(127, newValues[i]));

            if (prev[i] != newValues[i]) {

                boolean up = false;// = newValues[i] >= ANALOG_THRESHOLD;
                boolean down = false;// = newValues[i] <= -ANALOG_THRESHOLD;

                prev[i] = newValues[i];

                if (isAccelerometer) {
                    accelerometerBroadcast.putExtra(
                            BluezService.EVENT_ACCELEROMETERCHANGE_AXIS, i
                                    + report_axis_offset);
                    accelerometerBroadcast.putExtra(
                            BluezService.EVENT_ACCELEROMETERCHANGE_VALUE,
                            prev[i]);
                    m_context.sendBroadcast(accelerometerBroadcast);

                    // assuming we will only use the x-axis tilt...
                    m_position[i] += (newValues[i] - 13) * SCALAR;

                    // round the position in order to check for threshold
                    // values.
                    long tempPosition = Math.round(m_position[i]);
                    // if the position has moved to the next integer
                    if (m_roundedPosition[i] != tempPosition) {
                        // if it is positive acceleration
                        if (newValues[i] > 0)
                            up = true;
                        // if it is negative acceleration
                        else
                            down = true;
                        m_roundedPosition[i] = tempPosition;
                    }

                } else {
                    directionBroadcast.putExtra(
                            BluezService.EVENT_DIRECTIONALCHANGE_DIRECTION, i
                                    + report_axis_offset);
                    directionBroadcast
                            .putExtra(
                                    BluezService.EVENT_DIRECTIONALCHANGE_VALUE,
                                    prev[i]);
                    m_context.sendBroadcast(directionBroadcast);
                }
                if (up != buttonstates[i * 2]) {
                    buttonstates[i * 2] = up;
                    if (keys[i * 2] != KEYCODE_UNUSED) {
                        keypressBroadcast.putExtra(
                                BluezService.EVENT_KEYPRESS_ACTION,
                                up ? KeyEvent.ACTION_DOWN : KeyEvent.ACTION_UP);
                        keypressBroadcast.putExtra(
                                BluezService.EVENT_KEYPRESS_KEY, keys[i * 2]);
                        keypressBroadcast.putExtra(
                                BluezService.EVENT_KEYPRESS_ANALOG_EMULATED,
                                true);
                        m_context.sendBroadcast(keypressBroadcast);
                    }
                }
                if (down != buttonstates[(i * 2) + 1]) {
                    buttonstates[i * 2 + 1] = down;
                    if (keys[i * 2 + 1] != KEYCODE_UNUSED) {
                        keypressBroadcast.putExtra(
                                BluezService.EVENT_KEYPRESS_ACTION,
                                down ? KeyEvent.ACTION_DOWN
                                        : KeyEvent.ACTION_UP);
                        keypressBroadcast.putExtra(
                                BluezService.EVENT_KEYPRESS_KEY,
                                keys[(i * 2) + 1]);
                        keypressBroadcast.putExtra(
                                BluezService.EVENT_KEYPRESS_ANALOG_EMULATED,
                                true);
                        m_context.sendBroadcast(keypressBroadcast);
                    }
                }
            }
        }
    }

    /**
     * Appears to be a helper method between other methods and
     * handleDigitalButtons. Tinkers with the values before passing them off
     * with other parameters.
     * 
     * @param a probably a specific byte value
     * @param b probably a specific byte value
     */
    private void handleCoreButtons(int a, int b) {
        a = a & 0xff;
        b = b & 0xff;

        handleDigitalButtons((a << 8) | b, m_coreButtons, CORE_KEYS);
    }

    /**
     * A helper method between other methods and handleAnalongValues. In
     * particular handles any accelerometer data that is currently at hand.
     * 
     * @param x the value of the x-axis acceleration
     * @param y the value of the y-axis acceleration
     * @param z the value of the z-axis acceleration
     */
    private void handleAccelerometerData(byte x, byte y, byte z) {

        // Fix the lame Java signed byte representation
        int raw_x = ((int) x) & 0xff;
        int raw_y = ((int) y) & 0xff;
        int raw_z = ((int) z) & 0xff;

        // Assign the values and normalize them from
        // [0 -> 0x80 -> 0xff] to [-127, 0, +127]
        m_tmpAnalogValues[0] = raw_x - 0x80;
        m_tmpAnalogValues[1] = raw_y - 0x80;
        m_tmpAnalogValues[2] = raw_z - 0x80;
        handleAnalogValues(m_tmpAnalogValues, m_coreAccelerometerValues,
                m_coreEmulatedAccelerometerButtons, CORE_ACCELEROMETER_KEYS,
                CORE_ACCELEROMETER_AXIS_OFFSET, true);
    }

    /**
     * Probably handles any data passed that relates to attachments to the
     * wiimote.
     * 
     * @param data the byte data passed by the wiimote
     * @param offset the offset for the specific attachment?
     */
    private void handleExtensionData(byte[] data, int offset) {

        if (m_isClassicConnected) {

            int byteA = data[offset + 4] & 0xff;
            int byteB = data[offset + 5] & 0xff;
            handleDigitalButtons((byteA << 8) | byteB, m_classicButtons,
                    CLASSIC_KEYS);

            m_tmpAnalogValues[0] = data[offset] & 0x3f; // Left X
            m_tmpAnalogValues[1] = data[offset + 1] & 0x3f; // Left Y

            m_tmpAnalogValues[2] = ((data[offset + 2] >>> 7)
                    | ((data[offset + 1] >>> 5) & 0x6) | 
                    ((data[offset + 1] >>> 3) & 0x18)) & 0x1f; // Right
                                                               // X
            m_tmpAnalogValues[3] = data[offset + 2] & 0x1f; // Right Y

            m_tmpAnalogValues[4] = ((data[offset + 3] >>> 5) 
                    | ((data[offset + 2] >>> 2) & 0x18)) & 0x1f; // Left
                                                                 // trigger
            m_tmpAnalogValues[5] = data[offset + 3] & 0x1f; // Right trigger

            // We scale up the values so they are all in the -127/+127 range
            m_tmpAnalogValues[0] = ((byte) (m_tmpAnalogValues[3] << 2));
            m_tmpAnalogValues[1] = ((byte) (m_tmpAnalogValues[4] << 2));

            m_tmpAnalogValues[2] = ((byte) (m_tmpAnalogValues[5] << 3));
            m_tmpAnalogValues[3] = ((byte) (m_tmpAnalogValues[6] << 3));
            m_tmpAnalogValues[4] = ((byte) (m_tmpAnalogValues[7] << 3));
            m_tmpAnalogValues[5] = ((byte) (m_tmpAnalogValues[8] << 3));

            handleAnalogValues(m_tmpAnalogValues, m_classicAnalogValues,
                    m_classicEmulatedButtons, CLASSIC_ANALOG_KEYS, 0, false);

        } else if (m_isNunchuckConnected) {

            boolean isCPressed = (data[offset + 5] & 0x2) != 0;
            boolean isZPressed = (data[offset + 5] & 0x1) != 0;
            if (m_nunchuckButtons[0] != isCPressed) {
                m_nunchuckButtons[0] = isCPressed;
                if (NUNCHUCK_KEYS[0] != KEYCODE_UNUSED) {

                    keypressBroadcast.putExtra(
                            BluezService.EVENT_KEYPRESS_ACTION,
                            isCPressed ? KeyEvent.ACTION_DOWN
                                    : KeyEvent.ACTION_UP);
                    keypressBroadcast.putExtra(BluezService.EVENT_KEYPRESS_KEY,
                            NUNCHUCK_KEYS[0]);
                    keypressBroadcast.putExtra(
                            BluezService.EVENT_KEYPRESS_ANALOG_EMULATED, false);
                    m_context.sendBroadcast(keypressBroadcast);
                }
            }

            if (m_nunchuckButtons[1] != isZPressed) {
                m_nunchuckButtons[1] = isZPressed;
                if (NUNCHUCK_KEYS[1] != KEYCODE_UNUSED) {

                    keypressBroadcast.putExtra(
                            BluezService.EVENT_KEYPRESS_ACTION,
                            isZPressed ? KeyEvent.ACTION_DOWN
                                    : KeyEvent.ACTION_UP);
                    keypressBroadcast.putExtra(BluezService.EVENT_KEYPRESS_KEY,
                            NUNCHUCK_KEYS[1]);
                    keypressBroadcast.putExtra(
                            BluezService.EVENT_KEYPRESS_ANALOG_EMULATED, false);
                    m_context.sendBroadcast(keypressBroadcast);
                }
            }

            if (m_useAccelerometer) {
                m_tmpAnalogValues[0] = ((((int) data[offset + 2] & 0xff) << 2) 
                        | ((((int) data[offset + 5] & 0xff) >>> 6) & 0x3)) & 0x3ff;// Accelerometer
                                                                                    // X
                m_tmpAnalogValues[1] = ((((int) data[offset + 3] & 0xff) << 2) 
                        | ((((int) data[offset + 5] & 0xff) >>> 4) & 0x3)) & 0x3ff;// Accelerometer
                                                                                    // Y
                m_tmpAnalogValues[2] = ((((int) data[offset + 4] & 0xff) << 2) 
                        | ((((int) data[offset + 5] & 0xff) >>> 2) & 0x3)) & 0x3ff;// Accelerometer
                                                                                    // Z

                // We scale the values so they are all in the -127/+127 range
                m_tmpAnalogValues[0] = (m_tmpAnalogValues[0] >>> 2) - 0x80;
                m_tmpAnalogValues[1] = (m_tmpAnalogValues[1] >>> 2) - 0x80;
                m_tmpAnalogValues[2] = (m_tmpAnalogValues[2] >>> 2) - 0x80;

                handleAnalogValues(m_tmpAnalogValues,
                        m_nunchuckAccelerometerValues,
                        m_nunchuckEmulatedAccelerometerButtons,
                        NUNCHUCK_ACCELEROMETER_KEYS,
                        NUNCHUCK_ACCELEROMETER_AXIS_OFFSET, true);
            }

            m_tmpAnalogValues[0] = (((int) data[offset]) & 0xff); // Thumbstick
                                                                  // up/down
            m_tmpAnalogValues[1] = (((int) data[offset + 1]) & 0xff); // Thumbstick
                                                                      // left/right

            // We scale the values so they are all in the -127/+127 range
            m_tmpAnalogValues[0] = (int) ((m_tmpAnalogValues[0] - 0x78) * 1.27);
            m_tmpAnalogValues[1] = (int) ((m_tmpAnalogValues[1] - 0x81) * 1.3);

            // Bugfix, invert the Y-axis values:
            m_tmpAnalogValues[1] *= -1;

            handleAnalogValues(m_tmpAnalogValues, m_nunchuckAnalogValues,
                    m_nunchuckEmulatedButtons, NUNCHUCK_ANALOG_KEYS, 0, false);
        }
    }

    /**
     * This method returns a list of all the keys on the simulated keyboard that
     * can be 'pushed' by the wiimote.
     * 
     * @return a list of all keys able to be pushed
     */
    public static int[] getButtonCodes() {
        return new int[] {
                // Core/regular buttons
                KeyEvent.KEYCODE_DPAD_LEFT, KeyEvent.KEYCODE_DPAD_RIGHT,
                KeyEvent.KEYCODE_DPAD_UP, KeyEvent.KEYCODE_DPAD_DOWN,
                KeyEvent.KEYCODE_A, KeyEvent.KEYCODE_B,
                KeyEvent.KEYCODE_1,
                KeyEvent.KEYCODE_2,
                KeyEvent.KEYCODE_PLUS,
                KeyEvent.KEYCODE_MINUS,
                KeyEvent.KEYCODE_H,

                // Classic buttons
                KEYCODE_BUTTON_A, KEYCODE_BUTTON_B, KEYCODE_BUTTON_X,
                KEYCODE_BUTTON_Y, KEYCODE_BUTTON_L1, KEYCODE_BUTTON_R1,
                KEYCODE_BUTTON_L2,
                KEYCODE_BUTTON_R2,

                // Nunchuck/classic thumbstick keys
                KeyEvent.KEYCODE_W, KeyEvent.KEYCODE_Q, KeyEvent.KEYCODE_S,
                KeyEvent.KEYCODE_D, KeyEvent.KEYCODE_8, KeyEvent.KEYCODE_4,
                KeyEvent.KEYCODE_5, KeyEvent.KEYCODE_6,

                // Nunchuck buttons
                KeyEvent.KEYCODE_C, KeyEvent.KEYCODE_Z,

        // Core accelerometer keys
        // KeyEvent.KEYCODE_N, KeyEvent.KEYCODE_M,
        // KeyEvent.KEYCODE_J, KeyEvent.KEYCODE_K,
        // KeyEvent.KEYCODE_I, KeyEvent.KEYCODE_O,

        // Nunchuck accelerometer keys
        // KeyEvent.KEYCODE_V, KeyEvent.KEYCODE_B,
        // KeyEvent.KEYCODE_G, KeyEvent.KEYCODE_H,
        // KeyEvent.KEYCODE_Y, KeyEvent.KEYCODE_U,
        };
    }

    /**
     * This method returns a list of all the buttons on the wiimote and
     * attachments.
     * 
     * @return a list of all buttons on the wiimote and attachments.
     */
    public static int[] getButtonNames() {
        return new int[] {
                // Core/regular buttons
                R.string.wiimote_dpad_left,
                R.string.wiimote_dpad_right,
                R.string.wiimote_dpad_up,
                R.string.wiimote_dpad_down,
                R.string.wiimote_core_a,
                R.string.wiimote_core_b,
                R.string.wiimote_core_1,
                R.string.wiimote_core_2,
                R.string.wiimote_plus,
                R.string.wiimote_minus,
                R.string.wiimote_home,

                // Classic buttons
                R.string.wiimote_classic_a, R.string.wiimote_classic_b,
                R.string.wiimote_classic_x, R.string.wiimote_classic_y,
                R.string.wiimote_classic_l1,
                R.string.wiimote_classic_r1,
                R.string.wiimote_classic_l2,
                R.string.wiimote_classic_r2,

                // Nunchuck/classic thumbstick keys
                R.string.wiimote_thumb1_up, R.string.wiimote_thumb1_left,
                R.string.wiimote_thumb1_down, R.string.wiimote_thumb1_right,
                R.string.wiimote_thumb2_up, R.string.wiimote_thumb2_left,
                R.string.wiimote_thumb2_down, R.string.wiimote_thumb2_right,

                // Nunchuck buttons
                R.string.wiimote_nunchuck_c, R.string.wiimote_nunchuck_z,

        };
    }

}
