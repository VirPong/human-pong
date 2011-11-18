package com.testing;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.widget.TextView;

public class TestReciever extends BroadcastReceiver {

	public static final String ACCEL_TEST = "com.testing.accel";
	private int[] accel;
	//public static int counter = 0;
	
	@Override
	public void onReceive(Context context, Intent intent) {
		Bundle bundle = intent.getExtras();
		Intent i = new Intent(context, TestActivity.class);
		i.putExtra("accel", bundle);
		//context.sendBroadcast(i);
		accel = bundle.getIntArray("Accel");
		//if(counter%100==0)
		//	Log.d("HATRED", "" + accel[0]);
		//counter++;
	}
	
	public int[] get(){return accel;}

}
