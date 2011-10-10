//
//  iOSClientAppDelegate.m
//  iOSClient
//
//  Created by Josef Lange on 10/7/11.
//  Copyright 2011 Vir-Pong. All rights reserved.
//

#import "iOSClientAppDelegate.h"

@implementation iOSClientAppDelegate

@synthesize window = _window;

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    
    NSString* version = @"Version: ";
    NSString* versionText = [version stringByAppendingString:[[[NSBundle mainBundle] infoDictionary] objectForKey:@"CFBundleVersion"]];
    
    [versionString setText: versionText];
    
    [socketCommunicationLog setText:nil];
    
    [self.window makeKeyAndVisible];
    return YES;
}

- (void)applicationWillResignActive:(UIApplication *)application
{
    /*
     Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
     Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.
     */
}

- (void)applicationDidEnterBackground:(UIApplication *)application
{
    /*
     Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later. 
     If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
     */
}

- (void)applicationWillEnterForeground:(UIApplication *)application
{
    /*
     Called as part of the transition from the background to the inactive state; here you can undo many of the changes made on entering the background.
     */
}

- (void)applicationDidBecomeActive:(UIApplication *)application
{
    /*
     Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
     */
}

- (void)applicationWillTerminate:(UIApplication *)application
{
    /*
     Called when the application is about to terminate.
     Save data if appropriate.
     See also applicationDidEnterBackground:.
     */
}

- (void)dealloc
{
    [_window release];
    [super dealloc];
}

- (IBAction)pushPlayGameViewController:(id)sender {
    
    theGame = [[VPGameSession alloc] init];         // Instantiate the Game Session.
    
    [theGame startGameSessionAtAddress:@"10.150.1.204" onPort:3000];
    
    [navigationController pushViewController:playGameViewController animated:YES]; // Switch to Game View.
    
}

- (IBAction)pushRegisterAccountViewController:(id)sender{
     
    
    /* Load up the registration page */
    NSURL* registerPageURL = [NSURL URLWithString:@"http://cs340-serv/"];
    NSURLRequest* registerRequest = [NSURLRequest requestWithURL:registerPageURL];
    [registerAccountWebView loadRequest:registerRequest];
 
    [navigationController pushViewController:registerAccountViewController animated:YES]; // Switch to Registration View.
    
}

-(void)appendToSocketLog:(NSString *)string {
    
    NSString *concat = [[socketCommunicationLog text] stringByAppendingString:string];
    [socketCommunicationLog setText:concat];
    
}

@end
