package virpong.pong.android;

import android.os.Bundle;
import com.phonegap.*;
import android.util.Log;
import android.webkit.WebView;
/**
 * Entry point for the Android application.  Basically consider this to be a main method.
 * @author kwenholz
 *
 */
public class PongActivity extends DroidGap {
    /** Called when the activity is first created. 
     *  @param savedInstanceState something passed by the Android OS for initiation.
     */
    public void onCreate(Bundle savedInstanceState) {
    	super.onCreate(savedInstanceState);
    	super.init();
        KeySelect keys = new KeySelect(this, super.appView);
        super.appView.addJavascriptInterface(keys, "KeySelect");
        super.loadUrl("file:///android_asset/www/index.html"); //starts up PhoneGap!
    }
}
