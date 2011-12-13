//
//  Bluetooth.h
//  PhoneGap
//
//  Created by Nikolai Onken on 12/4/09.
//  Copyright 2009 UnitSpectra. All rights reserved.
//

#import <Foundation/Foundation.h>
//#import "PhoneGapCommand.h"
#ifdef PHONEGAP_FRAMEWORK
#import <PhoneGap/PGPlugin.h>
#else
#import "PGPlugin.h"
#endif
#import "BluetoothDelegate.h"

#import "btstack.h"

#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

@interface Bluetooth : PGPlugin {
int glob;
}

- (void) packet_handler: (uint8_t) packet_type: (uint16_t) channel: (uint8_t*) packet: (uint16_t) size;
void packet_handler(uint8_t packet_type, uint16_t channel, uint8_t *packet, uint16_t size);
void packet_handlerprime(uint8_t packet_type, uint16_t channel, uint8_t *packet, uint16_t size);
- (void) evaluateWevView;
- (void) initBlueTooth: (UIWebView*) webView;
- (int) globb;


@end
