package com.testing;

import android.app.Activity;
import android.content.ComponentName;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import com.testing.R;

public class TestActivity extends Activity {
	/** Called when the activity is first created. */
	   
	   
	   public void onCreate(Bundle savedInstanceState) {
	       super.onCreate(savedInstanceState);
	       /*TextView tv = new TextView(this);
	       tv.setText("Hello, Android");
	       setContentView(tv);*/
	       setContentView(R.layout.main);
	       Button btnSimple = (Button) findViewById(R.id.simpleButton);
	       btnSimple.setOnClickListener(new OnClickListener() {
	    	   
	    	   public void onClick(View v){
	    		   
	    		   Intent intent = new Intent();
	    		   intent.setComponent(new ComponentName("com.hexad.bluezime", "com.hexad.bluezime.BluezIMESettings"));
	    		   startActivityForResult(intent, 0);
	    	   }
	       });
	   }
	   /*
	   public boolean onKeyDown(int keyCode, KeyEvent event){
		   TextView tv = new TextView(this);
		   
		   switch(keyCode){
		   case KeyEvent.KEYCODE_X: tv.setText(i); break;
		   default: break;
		   }
		   i++;
		   setContentView(tv);
		   return super.onKeyDown(keyCode, event);
		   
	   }*/

}

