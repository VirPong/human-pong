//
//  VPGameSession.h
//  iOSClient
//
//  Created by Josef Lange on 10/7/11.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "VPPlayerPaddle.h"
#import "SocketIO.h"

@interface VPGameSession : NSObject<SocketIODelegate> {
        
    VPPlayerPaddle *playerOne;              // Our players.
    VPPlayerPaddle *playerTwo;      
    
    SocketIO *socketClient;          // Socket connection.
    
    NSString *gameLog;
    
}


-(void)startGameSessionAtAddress:(NSString *)address onPort:(int)port; 

- (void) socketIODidConnect:(SocketIO *)socket;
- (void) socketIODidDisconnect:(SocketIO *)socket;
- (void) socketIO:(SocketIO *)socket didReceiveMessage:(SocketIOPacket *)packet;
- (void) socketIO:(SocketIO *)socket didReceiveJSON:(SocketIOPacket *)packet;
- (void) socketIO:(SocketIO *)socket didReceiveEvent:(SocketIOPacket *)packet;
- (void) socketIO:(SocketIO *)socket didSendMessage:(SocketIOPacket *)packet;

@end
