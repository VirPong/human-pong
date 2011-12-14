package virpong.pong.android;

import com.phonegap.DroidGap;
import android.content.Context;
import android.view.inputmethod.InputMethodManager;
import android.webkit.WebView;
import android.util.Log;
import com.phonegap.api.Plugin;
import com.phonegap.api.PluginResult;
import com.phonegap.api.PluginResult.Status;

public class KeySelect{

        private WebView mAppView;
        private DroidGap mGap;

        public KeySelect(DroidGap gap, WebView view) {
            mAppView = view;
            mGap = gap;
        }

        public void showKeyBoards() {
            InputMethodManager mgr = (InputMethodManager) mGap.getSystemService(Context.INPUT_METHOD_SERVICE);
            mgr.showInputMethodPicker();
        }
}