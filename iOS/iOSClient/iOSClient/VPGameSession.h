//
//  VPGameSession.h
//  iOSClient
//
//  Created by Josef Lange on 10/7/11.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "AsyncSocket.h"
#import "VPPlayerPaddle.h"

@interface VPGameSession : NSObject {
    
    AsyncSocket *serverSocket;           // The AsyncSocket that will be establishing our socket connection.
    
    VPPlayerPaddle *playerOne;              // Our players.
    VPPlayerPaddle *playerTwo;      
    
}

-(BOOL)startGameSessionAtAddress:(NSString *)serverAddress
                          onPort:(UInt16)thePort;

@end
