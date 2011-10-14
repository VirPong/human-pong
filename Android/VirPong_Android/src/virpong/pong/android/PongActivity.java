package virpong.pong.android;

import android.os.Bundle;
import com.phonegap.*;

public class PongActivity extends DroidGap {
    /** Called when the activity is first created. */
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        super.loadUrl("file:///android_asset/www/index.html");
    }
}
