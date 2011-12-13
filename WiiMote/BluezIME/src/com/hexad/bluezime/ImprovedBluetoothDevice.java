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

import android.bluetooth.BluetoothClass;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.os.Parcel;
import android.os.ParcelUuid;

import java.io.IOException;
import java.lang.reflect.Constructor;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.UUID;

//Class that mimics a regular android.bluetooth.BluetoothDevice,
// but exposes some of the internal methods as regular methods

/**
 * This class mimics a regular bluetoothDevice but exposes more of the internal
 * methods.
 */
public class ImprovedBluetoothDevice {
    public final BluetoothDevice mDevice;

    // TODO: Suppressed by original author for a hopefully good reason
    @SuppressWarnings("rawtypes")
    /**
     * This method returns the methods of the class?
     * 
     * @param cls the class to get a method from
     * @param name the name of the method?
     * @param args the arguments of the method?
     */
    private static Method getMethod(Class cls, String name, Class[] args) {
        try {
            return cls.getMethod(name, args);
        } catch (Exception ex) {
            return null;
        }
    }

    // TODO: The original author supressed it for some good reason
    @SuppressWarnings("rawtypes")
    /**
     * This method returns the constructors of the class?
     * 
     * @param cls the class to get constructors from
     * @param args the arguments of the constructor
     */
    private static Constructor getConstructor(Class cls, Class[] args) {
        try {
            Constructor c = cls.getDeclaredConstructor(args);
            if (!c.isAccessible())
                c.setAccessible(true);
            return c;
        } catch (Exception ex) {
            return null;
        }
    }

    // private static final int TYPE_RFCOMM = 1;
    // private static final int TYPE_SCO = 2;
    private static final int TYPE_L2CAP = 3;

    private static final Method _createRfcommSocket = getMethod(
            BluetoothDevice.class, "createRfcommSocket",
            new Class[] { int.class });
    private static final Method _createInsecureRfcommSocket = getMethod(
            BluetoothDevice.class, "createInsecureRfcommSocket",
            new Class[] { int.class });
    private static final Method _setPin = getMethod(BluetoothDevice.class,
            "setPin", new Class[] { byte[].class });
    private static final Method _setPasskey = getMethod(BluetoothDevice.class,
            "setPasskey", new Class[] { int.class });
    @SuppressWarnings("rawtypes")
    private static final Constructor _socketConstructor = getConstructor(
            BluetoothSocket.class, new Class[] { int.class, int.class,
                    boolean.class, boolean.class, BluetoothDevice.class,
                    int.class, ParcelUuid.class });

    /**
     * This constructor doesn't do much aside from set a device.
     * 
     * @param base the device to be set
     */
    public ImprovedBluetoothDevice(BluetoothDevice base) {
        if (base == null)
            throw new NullPointerException();

        mDevice = base;
    }

    /**
     * This method just returns the device's record?
     * 
     * @param uuid the info to be returned?
     * @return a record from the device
     * @throws IOException if things go wrong
     */
    public BluetoothSocket createRfcommSocketToServiceRecord(UUID uuid)
            throws IOException {
        return mDevice.createRfcommSocketToServiceRecord(uuid);
    }

    public int describeContents() {
        return mDevice.describeContents();
    }

    public String getAddress() {
        return mDevice.getAddress();
    }

    public BluetoothClass getBluetoothClass() {
        return mDevice.getBluetoothClass();
    }

    public int getBondState() {
        return mDevice.getBondState();
    }

    public String getName() {
        return mDevice.getName();
    }

    public String toString() {
        return mDevice.toString();
    }

    public void writeToParcel(Parcel out, int flags) {
        mDevice.writeToParcel(out, flags);
    }

    /**
     * This method creates a socket...
     * 
     * @param channel the channel for the socket?
     * @return the socket created
     * @throws Exception when things go wrong
     */
    public BluetoothSocket createRfcommSocket(int channel) throws Exception {
        if (_createRfcommSocket == null)
            throw new NoSuchMethodException("createRfcommSocket");
        try {
            return (BluetoothSocket) _createRfcommSocket.invoke(mDevice,
                    channel);
        } catch (InvocationTargetException tex) {
            if (tex.getCause() instanceof Exception)
                throw (Exception) tex.getCause();
            else
                throw tex;
        }
    }

    /**
     * Creates an insecure socket...
     * 
     * @param channel the channel for the socket?
     * @return an insecure socket that was created
     * @throws Exception when things go wrong
     */
    public BluetoothSocket createInsecureRfcommSocket(int channel)
            throws Exception {
        if (_createInsecureRfcommSocket == null)
            throw new NoSuchMethodException("createInsecureRfcommSocket");

        try {
            return (BluetoothSocket) _createInsecureRfcommSocket.invoke(
                    mDevice, channel);
        } catch (InvocationTargetException tex) {
            if (tex.getCause() instanceof Exception)
                throw (Exception) tex.getCause();
            else
                throw tex;
        }
    }

    /**
     * Creates an LCAP socket...
     * 
     * @param channel the channel for the socket?
     * @return an LCAP socket that was created
     * @throws Exception when things go wrong
     */
    public BluetoothSocket createLCAPSocket(int channel) throws Exception {
        if (_socketConstructor == null)
            throw new NoSuchMethodException("new BluetoothSocket");

        try {
            return (BluetoothSocket) _socketConstructor.newInstance(TYPE_L2CAP,
                    -1, true, true, mDevice, channel, null);
        } catch (InvocationTargetException tex) {
            if (tex.getCause() instanceof Exception)
                throw (Exception) tex.getCause();
            else
                throw tex;
        }
    }

    /**
     * Creates an insecure LCAP socket...
     * 
     * @param channel the channel for the socket?
     * @return an insecure LCAP socket that was created
     * @throws Exception when things go wrong
     */
    public BluetoothSocket createInsecureLCAPSocket(int channel)
            throws Exception {
        if (_socketConstructor == null)
            throw new NoSuchMethodException("new BluetoothSocket");

        try {
            return (BluetoothSocket) _socketConstructor.newInstance(TYPE_L2CAP,
                    -1, false, false, mDevice, channel, null);
        } catch (InvocationTargetException tex) {
            if (tex.getCause() instanceof Exception)
                throw (Exception) tex.getCause();
            else
                throw tex;
        }
    }

    /**
     * This method sets the pin.
     * 
     * @param pin the pin to be set
     * @return whether the pin was set?
     * @throws Exception if there is no pin or no reason to set a pin?
     */
    public boolean setPin(byte[] pin) throws Exception {
        if (_setPin == null)
            throw new NoSuchMethodException("setPin");

        try {
            return (Boolean) _setPin.invoke(mDevice, pin);
        } catch (InvocationTargetException tex) {
            if (tex.getCause() instanceof Exception)
                throw (Exception) tex.getCause();
            else
                throw tex;
        }
    }

    /**
     * This method sets a passkey.
     * 
     * @param passkey the passkey to be set
     * @return if the passkey was set
     * @throws Exception if there is no passkey or reason for one
     */
    public boolean setPasskey(int passkey) throws Exception {
        if (_setPasskey == null)
            throw new NoSuchMethodException("setPasskey");

        try {
            return (Boolean) _setPasskey.invoke(mDevice, passkey);
        } catch (InvocationTargetException tex) {
            if (tex.getCause() instanceof Exception)
                throw (Exception) tex.getCause();
            else
                throw tex;
        }
    }
}
