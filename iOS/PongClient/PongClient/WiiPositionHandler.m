
//
//  WiiPositionHandler.m
//  
// Created by Nimish Nayak on 08/08/2011. 
// Copyright 2011 Nimish Nayak. All rights reserved.

#import "WiiPositionHandler.h"
#include "Bluetooth.h"

@implementation WiiPositionHandler 

@synthesize callbackID;
hci_con_handle_t con_handle;
BOOL First = YES;

-(void)print:(NSMutableArray*)arguments withDict:(NSMutableDictionary*)options  
{
	
	//The first argument in the arguments parameter is the callbackID.
	//We use this to send data back to the successCallback or failureCallback
	//through PluginResult.   
	self.callbackID = [arguments pop];
	
	//Get the string that javascript sent us 
	NSString *stringObtainedFromJavascript = [arguments objectAtIndex:0];                 
	
	//Create the Message that we wish to send to the Javascript
	
	NSMutableString *stringToReturn = [NSMutableString stringWithString: @"StringReceived:"];
	
	//Append the received string to the string we plan to send out        
	
	[stringToReturn appendString: stringObtainedFromJavascript];
	
	//Create Plugin Result
	
	PluginResult* pluginResult = [PluginResult resultWithStatus:PGCommandStatus_OK messageAsString:
								  [stringToReturn stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]];
	
	//Checking if the string received is HelloWorld or not
	
	if([stringObtainedFromJavascript isEqualToString:@"HelloWorld"]==YES)
		
	{
		
		//Call  the Success Javascript function
		
        [self writeJavascript: [pluginResult toSuccessCallbackString:self.callbackID]];
		
		
		
	}else
		
	{    
		
		//Call  the Failure Javascript function
		
		[self writeJavascript: [pluginResult toErrorCallbackString:self.callbackID]];
		
		
		
	}
	
	
	
}



//Virpong methods
-(void)getPosition:(NSMutableArray*)arguments withDict:(NSMutableDictionary*)options
{

    self.callbackID = [arguments pop];
    NSString *stringFromJavascript = [arguments objectAtIndex:0];
    NSInteger myInt = [stringFromJavascript intValue];
    
    //do the math 
    //int test = L2CAP_DATA_PACKET;
    myInt = getCalculatedPosition();
    
    NSMutableString *stringToReturn = [NSMutableString stringWithFormat:@"%d", myInt];
    
    PluginResult* pluginResult = [PluginResult resultWithStatus:PGCommandStatus_OK messageAsString:
								  [stringToReturn stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]];
    
    //Success and failure cases
    
    if(YES){
        [self writeJavascript: [pluginResult toSuccessCallbackString:self.callbackID]];
    }else{
        [self writeJavascript: [pluginResult toErrorCallbackString:self.callbackID]];
    }
}

//Virpong methods
-(void)connect:(NSMutableArray*)arguments withDict:(NSMutableDictionary*)options
{
    //printf("Failed to open connection to BTdaemon\n");
// connection code
    if(First == YES){
    run_loop_init(RUN_LOOP_COCOA);
        First = NO;
    }
    
	int err = bt_open();
	if (err) {
		printf("Failed to open connection to BTdaemon\n");
		return err;
	}
     printf("hello blarg blarg");
	bt_register_packet_handler(packet_handlerprime);
	bt_send_cmd(&btstack_set_power_mode, HCI_POWER_ON );
     printf("k blarg");
	run_loop_execute();
    printf("final blarg");
	//bt_close();
// connection code
    
    
    self.callbackID = [arguments pop];
    NSString *stringFromJavascript = [arguments objectAtIndex:0];
    NSInteger myInt = [stringFromJavascript intValue];
    
    //do the math 
    myInt += 77;
    
    NSMutableString *stringToReturn = [NSMutableString stringWithFormat:@"%d", myInt];
    
    PluginResult* pluginResult = [PluginResult resultWithStatus:PGCommandStatus_OK messageAsString:
								  [stringToReturn stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]];
    
    //Success and failure cases
    
    if(YES){
        [self writeJavascript: [pluginResult toSuccessCallbackString:self.callbackID]];
    }else{
        [self writeJavascript: [pluginResult toErrorCallbackString:self.callbackID]];
    }
}



-(int)positionTest:(NSMutableArray*)arguments withDict:(NSMutableDictionary*)options
{
    
    
//    //printf("Failed to open connection to BTdaemon\n");
//    // connection code
//    if(First == YES){
//        run_loop_init(RUN_LOOP_COCOA);
//        First = NO;
//    }
//    
//	int err = bt_open();
//	if (err) {
//		printf("Failed to open connection to BTdaemon\n");
//		return err;
//	}
//    printf("hello blarg blarg");
//	bt_register_packet_handler(packet_handlerprime);
//	bt_send_cmd(&btstack_set_power_mode, HCI_POWER_ON );
//    printf("k blarg");
//	run_loop_execute();
//    printf("final blarg");
//	//bt_close();
//    // connection code
//    
//    
//    self.callbackID = [arguments pop];
//    NSString *stringFromJavascript = [arguments objectAtIndex:0];
//    NSInteger myInt = [stringFromJavascript intValue];
//    
//    //do the math 
//    myInt += 77;
//    
//    NSMutableString *stringToReturn = [NSMutableString stringWithFormat:@"%d", myInt];
//    
//    PluginResult* pluginResult = [PluginResult resultWithStatus:PGCommandStatus_OK messageAsString:
//								  [stringToReturn stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]];
//    
//    //Success and failure cases
//    
//    if(YES){
//        [self writeJavascript: [pluginResult toSuccessCallbackString:self.callbackID]];
//    }else{
//        [self writeJavascript: [pluginResult toErrorCallbackString:self.callbackID]];
//    }
}

-(void)disconnect:(NSMutableArray*)arguments withDict:(NSMutableDictionary*)options
{
    printf("Failed to open connection to BTdaemon\n");
    // disconnection code
    printf("Disconnect baseband\n");
    bt_send_cmd(&hci_disconnect, con_handle, 0x13); // remote closed connection
    bt_close();
    // disconnection code
    
    
    self.callbackID = [arguments pop];
    NSString *stringFromJavascript = [arguments objectAtIndex:0];
    NSInteger myInt = [stringFromJavascript intValue];
    
    //do the math 
    myInt += 77;
    
    NSMutableString *stringToReturn = [NSMutableString stringWithFormat:@"%d", myInt];
    
    PluginResult* pluginResult = [PluginResult resultWithStatus:PGCommandStatus_OK messageAsString:
								  [stringToReturn stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]];
    
    //Success and failure cases
    
    if(YES){
        [self writeJavascript: [pluginResult toSuccessCallbackString:self.callbackID]];
    }else{
        [self writeJavascript: [pluginResult toErrorCallbackString:self.callbackID]];
    }
}
@end