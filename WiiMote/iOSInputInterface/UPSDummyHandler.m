#import "UPSDummyHandler.h"

@implementation UPSDummyHandler 
-(id) init {
	self = [super init];
	if (self) {
		previousPosition = 50;
		increasing = true;
		initialized = true;
	}
	return self;
}

-(int) position {
	if (initialized) {
		if (increasing) {
			previousPosition += 5;
			if (previousPosition == 100) {
				increasing = false;
			}
		} else {
			previousPosition -= 5;
			if (previousPosition == 0) {
				increasing = true;
			}
		}
	}
	return previousPosition;
}

-(void) disconnect {
	previousPosition = 50;
	increasing = true;
	initialized = false;
}
@end