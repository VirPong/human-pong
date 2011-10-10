//
//  VPPlayerPaddle.h
//  iOSClient
//
//  Created by Josef Lange on 10/7/11.
//  Copyright 2011 Vir-Pong. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface VPPlayerPaddle : NSObject {

    int         paddlePosition;
    UIColor*    paddleColor;
    NSString*   playerName;

}

-(int)getPaddlePosition;
-(void)setPaddlePosition: (int)position;

-(UIColor*)getColor;
-(void)setColor: (UIColor *)theColor;

-(NSString*)getPlayerName;
-(void)setPlayerName: (NSString *)theName;
    
@end
