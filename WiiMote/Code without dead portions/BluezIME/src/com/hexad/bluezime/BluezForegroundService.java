package com.hexad.bluezime;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Intent;
import android.os.IBinder;

public class BluezForegroundService extends Service {

	static final String ACTION_START = "com.hexad.bluezime.START_FG_SERVICE";
	static final String ACTION_STOP = "com.hexad.bluezime.STOP_FG_SERVICE";
	private static final int NOTIFICATION_ID = 10; 
	private NotificationManager m_notificationManager;
	private int m_connectionCount = 0;
	
	@Override
	public void onCreate() {
		super.onCreate();
	}

	@Override
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
	
	private void showNotification() {
		m_notificationManager = (NotificationManager)getSystemService(NOTIFICATION_SERVICE);
		PendingIntent settingsIntent = PendingIntent.getActivity(this, 0, new Intent(this, BluezIMESettings.class), 0);

		Notification notification = new Notification(R.drawable.icon, null, System.currentTimeMillis());
		notification.setLatestEventInfo(getApplicationContext(), getResources().getString(R.string.app_name), getResources().getString(R.string.notification_text), settingsIntent);
		notification.flags |= Notification.FLAG_ONGOING_EVENT;
		notification.flags |= Notification.FLAG_NO_CLEAR;

		m_notificationManager.notify(NOTIFICATION_ID, notification);
		startForeground(NOTIFICATION_ID, notification);
	}

	@Override
	public void onDestroy() {
		m_notificationManager.cancel(NOTIFICATION_ID);
		super.onDestroy();
	}

	@Override
	public IBinder onBind(Intent intent) {
		return null;
	}
}
