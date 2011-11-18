package com.testing;

import android.app.Activity;
import android.content.BroadcastReceiver;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
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
    accels_ = accel;
  }

/**
 * Shows the acceleration data through text fields.
 */
  public final void showAccel()
  {
    TextView tx = (TextView) findViewById(R.id.xAxis);
    TextView ty = (TextView) findViewById(R.id.yAxis);
    TextView tz = (TextView) findViewById(R.id.zAxis);
    tx.setText("" + accels_[0]);
    ty.setText("" + accels_[1]);
    tz.setText("" + accels_[2]);
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
    accels_ = accel;
  }

/**
 * Returns the acceleration data currently stored.
 * @return the acceleration values currently stored
 */
  public final int[] getAccel()
  {
    return accels_;
  }

}