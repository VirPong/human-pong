
//
//  WiiPositionHandler.h
//
//  Created by Nimish Nayak on 08/08/2011. 
//  Copyright 2011 Nimish Nayak. All rights reserved.
#import <Foundation/Foundation.h>
#ifdef PHONEGAP_FRAMEWORK
#import <PhoneGap/PGPlugin.h>
#else
#import "PGPlugin.h"
#endif

@interface WiiPositionHandler : PGPlugin {
    
	NSString* callbackID;  
    BOOL increasing;
}

@property (nonatomic, copy) NSString* callbackID;

//Instance Method  
- (void) print:(NSMutableArray*)arguments withDict:(NSMutableDictionary*)options;
//VirPong Methods
- (void) getPosition:(NSMutableArray*)arguments withDict:(NSMutableDictionary*)options;
//VirPong Methods
- (void) connect:(NSMutableArray*)arguments withDict:(NSMutableDictionary*)options;
- (void) disconnect:(NSMutableArray*)arguments withDict:(NSMutableDictionary*)options;
@end