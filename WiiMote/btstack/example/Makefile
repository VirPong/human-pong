CC = /Developer/Platforms/iPhoneOS.platform/Developer/usr/bin/arm-apple-darwin10-gcc-4.2.1
LDFLAGS  =  -framework CoreFoundation -framework Foundation -framework Foundation -framework CoreFoundation -framework UIKit -lobjc -L/Developer/Platforms/iPhoneOS.platform/Developer/SDKs/iPhoneOS4.3.sdk/System/Library/Frameworks/IOKit.framework/Versions/A -lIOKit /Developer/Platforms/iPhoneOS.platform/Developer/SDKs/iPhoneOS4.3.sdk/System/Library/PrivateFrameworks/BluetoothManager.framework/BluetoothManager -lBTstack -L../src
CPPFLAGS =  -isysroot /Developer/Platforms/iPhoneOS.platform/Developer/SDKs/iPhoneOS4.3.sdk -Werror -Wall -Wpointer-arith -I.. -I../include
prefix = /usr/local

all: test rfcomm-cat rfcomm-echo  rfcomm-test inquiry l2cap-server l2cap-throughput

test: test.c
	$(CC) $(CPPFLAGS) -o $@ $< $(LDFLAGS)
	# export CODESIGN_ALLOCATE=/Developer/Platforms/iPhoneOS.platform/Developer/usr/bin/codesign_allocate ; ldid -S $@

l2cap-server: l2cap-server.c
	$(CC) $(CPPFLAGS) -o $@ $< $(LDFLAGS)
	# export CODESIGN_ALLOCATE=/Developer/Platforms/iPhoneOS.platform/Developer/usr/bin/codesign_allocate ; ldid -S $@

l2cap-throughput: l2cap-throughput.c
	$(CC) $(CPPFLAGS) -o $@ $< $(LDFLAGS)
	# export CODESIGN_ALLOCATE=/Developer/Platforms/iPhoneOS.platform/Developer/usr/bin/codesign_allocate ; ldid -S $@

inquiry: inquiry.c
	$(CC) $(CPPFLAGS) -o $@ $< $(LDFLAGS)
	# export CODESIGN_ALLOCATE=/Developer/Platforms/iPhoneOS.platform/Developer/usr/bin/codesign_allocate ; ldid -S $@

rfcomm-cat: rfcomm-cat.c
	$(CC) $(CPPFLAGS) -o $@ $< $(LDFLAGS)
	# export CODESIGN_ALLOCATE=/Developer/Platforms/iPhoneOS.platform/Developer/usr/bin/codesign_allocate ; ldid -S $@

rfcomm-echo: rfcomm-echo.c
	$(CC) $(CPPFLAGS) -o $@ $< $(LDFLAGS)
	# export CODESIGN_ALLOCATE=/Developer/Platforms/iPhoneOS.platform/Developer/usr/bin/codesign_allocate ; ldid -S $@

rfcomm-test: rfcomm-test.c
	$(CC) $(CPPFLAGS) -o $@ $< $(LDFLAGS)
	# export CODESIGN_ALLOCATE=/Developer/Platforms/iPhoneOS.platform/Developer/usr/bin/codesign_allocate ; ldid -S $@

clean:
	rm -f test mitm rfcomm-cat rfcomm-echo inquiry l2cap-server l2cap-throughput obex
	
install:    
	echo "nothing to be done"

