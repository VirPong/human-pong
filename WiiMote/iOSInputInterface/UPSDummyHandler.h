#import "UPSPositionHandler.h"

@interface UPSDummyHandler: UPSPositionHandler {
@private
	BOOL initialized;
	int previousPosition;
	BOOL increasing;
}
@end