package com.android.Bluetooth;

import com.phonegap.*;
import android.os.Bundle;

public class BluetoothActivity extends DroidGap {
    /** Called when the activity is first created. */
    
	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        super.loadUrl("file:///android_asset/www/index.html");
    }
}
