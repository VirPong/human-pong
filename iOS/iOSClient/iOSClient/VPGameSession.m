//
//  VPGameSession.m
//  iOSClient
//
//  Created by Josef Lange on 10/7/11.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import "VPGameSession.h"
#import "iOSClientAppDelegate.h"

@implementation VPGameSession

- (id)init
{
    self = [super init];
    if (self) {
        
        playerOne = [[VPPlayerPaddle alloc] init];
        playerTwo = [[VPPlayerPaddle alloc] init];
        
        [playerOne setPlayerName:@"JOSEF"];
                                               
        }
    return self;
}

-(void)startGameSessionAtAddress:(NSString *)address onPort:(int)port {
    
    socketClient = [[SocketIO alloc] initWithDelegate:self];
    
    [socketClient connectToHost:address onPort:port];
        
    [socketClient sendMessage:@"findAGameForMe"];
    [socketClient sendMessage:[NSString stringWithFormat: @"My name is %@", [playerOne getPlayerName]]];
    
    
}

-(void)socketIO:(SocketIO *)socket didReceiveEvent:(SocketIOPacket *)packet {
    
    iOSClientAppDelegate *myDelegate = (iOSClientAppDelegate *)[[UIApplication sharedApplication] delegate];
    
    [myDelegate appendToSocketLog:packet.data];
    
    NSLog(@"EVENT RECEIVED: %@", packet.data);
    
}

-(void)socketIO:(SocketIO *)socket didReceiveMessage:(SocketIOPacket *)packet {
    
    NSLog(@"MESSAGE RECEIVED: %@", packet.data);
    
}


- (void) socketIODidConnect:(SocketIO *)socket {
    
    NSLog(@"Connection Successful!");
    
    
}
- (void) socketIODidDisconnect:(SocketIO *)socket {
    
    NSLog(@"DISCONNECTINGGGG");
    
}
- (void) socketIO:(SocketIO *)socket didReceiveJSON:(SocketIOPacket *)packet {
    
    
}
- (void) socketIO:(SocketIO *)socket didSendMessage:(SocketIOPacket *)packet {
    
    NSLog(@"Sent something!");
    
}

@end
