//
//  VPGameSession.m
//  iOSClient
//
//  Created by Josef Lange on 10/7/11.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import "VPGameSession.h"

@implementation VPGameSession

- (id)init
{
    self = [super init];
    if (self) {
        
        playerOne = [[VPPlayerPaddle alloc] init];
        playerTwo = [[VPPlayerPaddle alloc] init];
              
        serverSocket = [[AsyncSocket alloc] initWithDelegate:self];
                                 
        }
    return self;
}

-(BOOL) startGameSessionAtAddress:(NSString *)serverAddress
                           onPort:(UInt16)thePort
{
    
    if([serverSocket connectToHost:serverAddress onPort:thePort error:nil]) { 
        return TRUE;
    } else {
        return FALSE;
    }
        
    
}

@end
