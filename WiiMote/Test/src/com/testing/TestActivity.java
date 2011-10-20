package com.testing;

import android.app.Activity;
import android.app.Service;
import android.content.BroadcastReceiver;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.ServiceConnection;
import android.os.Bundle;
import android.os.IBinder;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;
import com.testing.R;

public class TestActivity extends Activity {
	
	//private TestReciever tRec = new TestReciever();
	private BroadcastReceiver mRec = new BroadcastReceiver(){
		public void onReceive(Context context, Intent intent){
			//Log.d("HATE", "" + intent.getIntArrayExtra("accel"));
			//Log.d("YOU", "" + intent.getIntArrayExtra("Accel"));
			setAccel(intent);
		}
	};
	
	   public void onCreate(Bundle savedInstanceState) {
		   //basic stuff
	       super.onCreate(savedInstanceState);
	       setContentView(R.layout.main);
	       //loads the bluez stuff
	       Button btnSimple = (Button) findViewById(R.id.simpleButton);
	       btnSimple.setOnClickListener(new OnClickListener() {
	    	   public void onClick(View v){
	    		   
	    		   Intent intent = new Intent();
	    		   intent.setComponent(new ComponentName("com.hexad.bluezime", "com.hexad.bluezime.BluezIMESettings"));
	    		   startActivityForResult(intent, 0);
	    	   }
	       });
	       
	       //can do other things
	       Button button = (Button) findViewById(R.id.accelButton);
	       button.setOnClickListener(new OnClickListener(){
			public void onClick(View v) {
				//Log.d("WII", "" + tRec.get());
			}
	    	   
	       });
	   }
	   
	   public void onResume(){
		   super.onResume();
		   IntentFilter iff = new IntentFilter();
		   iff.addAction("com.hexad.bluezime.intent.action.TEST");
		   registerReceiver(mRec,iff);
		   //registerReceiver(tRec, iff);
		   
	   }
	   
	   public void onPause(){
		   super.onPause();
		   //unregisterReceiver(tRec);
		   unregisterReceiver(mRec);
	   }
	   
	   
	   public void setAccel(int[] accel){
		   TextView tx = (TextView) findViewById(R.id.xAxis);
	       TextView ty = (TextView) findViewById(R.id.yAxis);
	       TextView tz = (TextView) findViewById(R.id.zAxis);
	       tx.setText(""+accel[0]);
	       ty.setText(""+accel[1]);
	       tz.setText(""+accel[2]);
	   }
	   
	   public void setAccel(Intent intent){
		   int accel[] = intent.getIntArrayExtra("Accel");
		   //Log.d("nope", "doesn't seem to work: " + accel);
		   TextView tx = (TextView) findViewById(R.id.xAxis);
	       TextView ty = (TextView) findViewById(R.id.yAxis);
	       TextView tz = (TextView) findViewById(R.id.zAxis);
	       tx.setText(""+accel[0]);
	       ty.setText(""+accel[1]);
	       tz.setText(""+accel[2]);
	   }
	   
}

