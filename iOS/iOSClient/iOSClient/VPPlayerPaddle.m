//
//  VPPlayerPaddle.m
//  iOSClient
//
//  Created by Josef Lange on 10/7/11.
//  Copyright 2011 Vir-Pong. All rights reserved.
//

#import "VPPlayerPaddle.h"

@implementation VPPlayerPaddle

- (id)init
{
    self = [super init];
    if (self) {
        // Initialization code here.
    }
    
    return self;
}

-(int)getPaddlePosition {

    return paddlePosition;

}

-(void)setPaddlePosition: (int)position {
    
    paddlePosition = position;
    
}

-(UIColor*)getColor {
    
    return paddleColor;
    
}
-(void)setColor: (UIColor*)theColor {
    
    paddleColor = theColor;
    
}

-(NSString*)getPlayerName {
    
    return playerName;
    
}
-(void)setPlayerName: (NSString*)theName {
    
    playerName = theName;
    
}

@end
