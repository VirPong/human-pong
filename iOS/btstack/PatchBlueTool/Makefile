CC = /Developer/Platforms/iPhoneOS.platform/Developer/usr/bin/arm-apple-darwin10-gcc-4.2.1
LDFLAGS  =  -framework CoreFoundation -framework Foundation -framework Foundation -framework CoreFoundation -framework UIKit -lobjc -L/Developer/Platforms/iPhoneOS.platform/Developer/SDKs/iPhoneOS4.3.sdk/System/Library/Frameworks/IOKit.framework/Versions/A -lIOKit /Developer/Platforms/iPhoneOS.platform/Developer/SDKs/iPhoneOS4.3.sdk/System/Library/PrivateFrameworks/BluetoothManager.framework/BluetoothManager
CPPFLAGS =  -isysroot /Developer/Platforms/iPhoneOS.platform/Developer/SDKs/iPhoneOS4.3.sdk -Werror -Wall -Wpointer-arith
prefix = /usr/local

all: PatchBlueTool

PatchBlueTool: PatchBlueTool.c
	$(CC) $(CPPFLAGS) -o $@ $< $(LDFLAGS)
	# export CODESIGN_ALLOCATE=/Developer/Platforms/iPhoneOS.platform/Developer/usr/bin/codesign_allocate ; ldid -S $@

clean:
	rm -f PatchBlueTool
	
install:    
	echo "nothing to be done"

