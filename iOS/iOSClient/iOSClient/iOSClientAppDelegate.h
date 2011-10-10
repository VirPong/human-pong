//
//  iOSClientAppDelegate.h
//  iOSClient
//
//  Created by Josef Lange on 10/7/11.
//  Copyright 2011 Vir-Pong. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "VPGameSession.h"

@interface iOSClientAppDelegate : NSObject <UIApplicationDelegate> {
    
    VPGameSession *theGame;                 // The game session (when we start it).
    
    IBOutlet UILabel *versionString;        // The string that will print the version below the logo.
    
    IBOutlet UINavigationController *navigationController;  // The controller of all the navigation.
    
    IBOutlet UIViewController *playGameViewController;      // Controller of the game view.
    
    IBOutlet UIViewController *registerAccountViewController;  // Controller of the webView that
                                                                // is for registering an account.
    IBOutlet UIWebView *registerAccountWebView;                 // WebView for the account registration.
    
}

@property (nonatomic, retain) IBOutlet UIWindow *window;

-(IBAction)pushPlayGameViewController:(id)sender; // Switches the Navigation View to the Game View.
-(IBAction)pushRegisterAccountViewController:(id)sender; // Switches the Navigation View to the Registration View.


@end
