package com.hexad.bluezime;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Intent;
import android.os.IBinder;

/**
 * This class handles the notifications I believe.
 */
public class BluezForegroundService extends Service {

    static final String ACTION_START = "com.hexad.bluezime.START_FG_SERVICE";
    static final String ACTION_STOP = "com.hexad.bluezime.STOP_FG_SERVICE";
    private static final int NOTIFICATION_ID = 10;
    private NotificationManager m_notificationManager;
    private int m_connectionCount = 0;

    @Override
    /**
     * Doesn't do anymore than what the inherited version does. 
     */
    public void onCreate() {
        super.onCreate();
    }

    @Override
    /**
     * This method shows start notifications and tracks the number of connections and such?
     * 
     * @param intent the intent with the start or stop intention
     * @param flags not used
     * @param startId not used
     */
    public int onStartCommand(Intent intent, int flags, int startId) {
        if (ACTION_START.equals(intent.getAction())) {
            if (m_connectionCount == 0)
                showNotification();
            m_connectionCount++;
            return START_STICKY;
        } else if (ACTION_STOP.equals(intent.getAction())) {
            m_connectionCount--;
            if (m_connectionCount <= 0)
                stopSelf();
        }
        return START_NOT_STICKY;
    }

    /**
     * This method is what creates the notification manager and shows all the notifications.s
     */
    private void showNotification() {
        m_notificationManager = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
        PendingIntent settingsIntent = PendingIntent.getActivity(this, 0,
                new Intent(this, BluezIMESettings.class), 0);

        Notification notification = new Notification(R.drawable.icon, null,
                System.currentTimeMillis());
        notification.setLatestEventInfo(getApplicationContext(), getResources()
                .getString(R.string.app_name),
                getResources().getString(R.string.notification_text),
                settingsIntent);
        notification.flags |= Notification.FLAG_ONGOING_EVENT;
        notification.flags |= Notification.FLAG_NO_CLEAR;

        m_notificationManager.notify(NOTIFICATION_ID, notification);
        startForeground(NOTIFICATION_ID, notification);
    }

    @Override
    /**
     * Does what the inherited version does and also cancels the notifications.
     */
    public void onDestroy() {
        m_notificationManager.cancel(NOTIFICATION_ID);
        super.onDestroy();
    }

    @Override
    /**
     * Does absolutely nothing. Always returns null.
     */
    public IBinder onBind(Intent intent) {
        return null;
    }
}
