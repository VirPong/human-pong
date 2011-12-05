package com.testing;

import java.util.Stack;

import android.app.Activity;
import android.content.BroadcastReceiver;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

/**
 * A proof-of-concept class that simply displays the acceleration data
 * to the screen.
 *
 * @author Matthew Klein
 */

public class TestActivity extends Activity
{

/**
* Holds the acceleration data given by the wiimote as [x,y,z].
*/
  private int[] accels_;

/**
* Local receiver that catches the acceleration broadcast from BluezIME.
*/
  private BroadcastReceiver mRec_ = new BroadcastReceiver()
  {
    public void onReceive(Context context, Intent intent)
    {
      setAccel(intent);
      showPos();
      showAccel();
      
    }
  };

/**
 * Called when the activity is first created. Creates the UI and not much else.
 *
 * @param savedInstanceState Only really used by the android phone I believe
 */
  public final void onCreate(Bundle savedInstanceState)
  {
    //basic stuff
    super.onCreate(savedInstanceState);
    setContentView(R.layout.main);

    //loads the bluez stuff
    Button btnSimple = (Button) findViewById(R.id.simpleButton);
    btnSimple.setOnClickListener(new OnClickListener()
    {
      public void onClick(View v)
      {
        Intent intent = new Intent();
        intent.setComponent(new ComponentName("com.hexad.bluezime",
          "com.hexad.bluezime.BluezIMESettings"));
        startActivityForResult(intent, 0);
      }
    });
  }

  /**
   * Called when activity is resumed. Starts up the broadcast receiver.
   */
  public final void onResume()
  {
    super.onResume();
    IntentFilter iff = new IntentFilter();
    iff.addAction("com.hexad.bluezime.intent.action.TEST");
    registerReceiver(mRec_, iff);
  }

  /**
   * Called when the activity is paused.
   */
  public final void onPause()
  {
    super.onPause();
    unregisterReceiver(mRec_);
  }

/**
 * Takes the accel as an array of ints to set the field.
 * @param accel the array of accel to be sete
 */
  public final void setAccel(int[] accel)
  {
    if (accels_ == null) {
      accels_ = new int[3];
    }
    //for(int i = 0; i < accel.length; i++)
    //	accels_[i] = accel[i]-13;
    accels_[0] = accel[0]-13;
    accels_[1] = accel[1]-11;
    accels_[2] = accel[2]-11;
    	
  }

/**
 * Shows the acceleration data through text fields.
 */
  

  public double position = 0;
  public double SCALAR = .1;
  public double size = 1;
  public double SCALAR2 = .004;
  public double zAxis;
  
  public final void showAccel()
  {
    TextView tx = (TextView) findViewById(R.id.xAxis);
    TextView ty = (TextView) findViewById(R.id.yAxis);
    TextView tz = (TextView) findViewById(R.id.zAxis);
    //tx.setText("" + (accels_[0]));
    //ty.setText("" + accels_[1]);
    //tz.setText("" + accels_[2]);
    //TextView tp = (TextView) findViewById(R.id.PosX);
    //TextView ta = (TextView) findViewById(R.id.PosY);
    //TextView pos = (TextView) findViewById(R.id.PosZ);
    
    //Does the tilt portion for accelerometer, scaling and limiting
    position += accels_[0]*SCALAR;
    if(position > 100)
    	position = 100;
    else if(position < 0)
    	position = 0;
    
    
    //Gives out a sum acceleration from all axes with gravity nullified
    double norm = Math.sqrt(accels_[0]*accels_[0]+accels_[1]*accels_[1]+accels_[2]*accels_[2])-28;
    //does scaling and limiting for shaking
    size += norm*SCALAR2;
    size -= .1;
    if(size < 1)
    	size = 1;
    else if(size > 3)
    	size = 3;
    
    //does the one-axis shaking that Paul thought of
    if(accels_[1] > 40)
    	zAxis += accels_[1]*SCALAR2*2;
    zAxis -= .1;
    if(zAxis < 1)
    	zAxis = 1;
    else if(zAxis > 3)
    	zAxis = 3;
    
    
    tx.setText("" + (int)position);
    ty.setText("" + size);
    tz.setText("" + zAxis);
    
  }

/**
 * Sets the accel using an intent with a bundle.
 * @param intent the intent that hopefully has the necessary bundle.
 */
  public final void setAccel(Intent intent)
  {
    int[] accel = intent.getIntArrayExtra("Accel");
    if (accels_ == null) {
      accels_ = new int[3];
    }
    //for(int i = 0; i < accel.length; i++)
    //	accels_[i] = accel[i]-13;
    	
    accels_[0] = accel[0]-13;
    accels_[1] = accel[1]-11;
    accels_[2] = accel[2]-11;
  }

/**
 * Returns the acceleration data currently stored.
 * @return the acceleration values currently stored
 */
  public final int[] getAccel()
  {
    return accels_;
  }
  
  public final void showPos(){
	  int acc = 0;
	  if(Math.abs(accels_[0]) < 6)
		  acc = 0;
	  else if(Math.abs(accels_[0]) < 18)
		  acc = Integer.signum(accels_[0]);
	  else if(Math.abs(accels_[0]) < 30)
		  acc = Integer.signum(accels_[0]) * 2;
	  else
		  acc = Integer.signum(accels_[0]) * 3;
	  
	  //position += acc;
	  
	  //TextView tpx = (TextView) findViewById(R.id.PosX);
	  //tpx.setText("" + acc );
	  //TextView tpy = (TextView) findViewById(R.id.PosY);
	  //tpy.setText("" + position);
	  //if(acc != 0)
		//  Log.d("Acceleration","" + acc);


  }

}