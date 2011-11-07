/*

 * THIS SOFTWARE IS PROVIDED BY MATTHIAS RINGWALD AND CONTRIBUTORS
 * ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL MATTHIAS
 * RINGWALD OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS
 * OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
 * THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 *
 */

/*
 *   After downloading BTStack, replace the test.c file with this test.c file
 * This test.c file should be the one you secure copy on to the iphone.
 * This code demonstrates connectivity with the Wii remote.
 * 
 *  Created by Matthias Ringwald on 7/14/09.
 * Edited by Paul Makl
 */

#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include <btstack/btstack.h>
#include <btstack/hci_cmds.h>


#include "compat-svn.c"


bd_addr_t addr = {0x00, 0x24, 0x1E, 0x76, 0x8E, 0x92 };  // WiiMote

hci_con_handle_t con_handle;
uint16_t source_cid_interrupt;
uint16_t source_cid_control;

// prints out accelerometer readings from wii remote. stores them in an
// array of hex values (accdataarray)
void hexdumpacc(void *data, int size, int *accdataarray){
	// print the accelerometer data
	printf("%02i X axis acc| ", ((uint8_t *)data)[4]);
	printf("%02i Y axis acc| ", ((uint8_t *)data)[5]);
	printf("%02i z axis acc| ", ((uint8_t *)data)[6]);
	// store the values in values
	accdataarray[0] = ((uint8_t *)data)[4];
	accdataarray[1] = ((uint8_t *)data)[5];
	accdataarray[2] = ((uint8_t *)data)[6];
    printf("\n");
}

void packet_handler(uint8_t packet_type, uint16_t channel, uint8_t *packet, uint16_t size){
	
	bd_addr_t event_addr;

	switch (packet_type) {
			
		case L2CAP_DATA_PACKET:
			// prints out accelerometer readings
			printf("source cid %x -- ", channel);
			int accarray[] = {0x00, 0x00, 0x00};
			hexdumpacc(packet, size, accarray);
	
			// HOME => disconnect
			if (packet[0] == 0xA1) {							// Status report
				if (packet[1] == 0x30 || packet[1] == 0x31) {   // type 0x30 or 0x31
					if (packet[3] & 0x080) {                   // homne button pressed
						printf("Disconnect baseband\n");
						bt_send_cmd(&hci_disconnect, con_handle, 0x13); // remote closed connection
					}
				}
			}
			break;
			
		case HCI_EVENT_PACKET:
			
			switch (packet[0]) {

				case BTSTACK_EVENT_POWERON_FAILED:
					printf("HCI Init failed - make sure you have turned off Bluetooth in the System Settings\n");
					exit(1);
					break;
					
				case BTSTACK_EVENT_STATE:
					// bt stack activated, get started - disable pairing
					if (packet[2] == HCI_STATE_WORKING) {
						bt_send_cmd(&hci_write_authentication_enable, 0);
					}
					break;
					
				case HCI_EVENT_LINK_KEY_REQUEST:
					printf("HCI_EVENT_LINK_KEY_REQUEST \n");
					// link key request
					bt_flip_addr(event_addr, &packet[2]); 
					bt_send_cmd(&hci_link_key_request_negative_reply, &event_addr);
					break;
					
				case HCI_EVENT_PIN_CODE_REQUEST:
					// inform about pin code request
					printf("Please enter PIN 0000 on remote device\n");
					bt_flip_addr(event_addr, &packet[2]); 
					bt_send_cmd(&hci_pin_code_request_reply, &event_addr, 4, "0000");
					break;
					
				case L2CAP_EVENT_CHANNEL_OPENED:
					// inform about new l2cap connection
					// inform about new l2cap connection
					bt_flip_addr(event_addr, &packet[3]);
					uint16_t psm = READ_BT_16(packet, 11); 
					uint16_t source_cid = READ_BT_16(packet, 13); 
					con_handle = READ_BT_16(packet, 9);
					if (packet[2] == 0) {
						printf("Channel successfully opened: %s, handle 0x%02x, psm 0x%02x, source cid 0x%02x, dest cid 0x%02x\n",
							   bd_addr_to_str(event_addr), con_handle, psm, source_cid,  READ_BT_16(packet, 15));
						
						if (psm == 0x13) {
							source_cid_interrupt = source_cid;
							// interupt channel openedn succesfully, now open control channel, too.
							bt_send_cmd(&l2cap_create_channel, event_addr, 0x11);
						} else {
							source_cid_control = source_cid;
							// request acceleration data..
							uint8_t setMode31[] = { 0x52, 0x12, 0x00, 0x31 };
							bt_send_l2cap( source_cid, setMode31, sizeof(setMode31));
							// stop blinking
							uint8_t setLEDs[] = { 0x52, 0x11, 0x10 };
							bt_send_l2cap( source_cid, setLEDs, sizeof(setLEDs));
						}
					} else {
						printf("L2CAP connection to device %s  failed. status code %u\n",  bd_addr_to_str(event_addr), packet[2]);
						exit(1);
					}
					break;
					
				case HCI_EVENT_DISCONNECTION_COMPLETE:
					// connection closed -> quit tes app
					printf("Basebank connection closed, exit.\n");
					exit(0);
					break;
					
				case HCI_EVENT_COMMAND_COMPLETE:
					// connect to HID device (PSM 0x13) at addr
					if ( COMMAND_COMPLETE_EVENT(packet, hci_write_authentication_enable) ) {
						bt_send_cmd(&l2cap_create_channel, addr, 0x13);
						printf("Press 1+2 on WiiMote to make it discoverable - Press HOME to disconnect later :)\n");
					}
					break;
					
				default:
					// other event
					break;
			}
			break;
			
		default:
			// other packet type
			break;
	}
}

int main (int argc, const char * argv[]){
	run_loop_init(RUN_LOOP_POSIX);
	int err = bt_open();
	if (err) {
		printf("Failed to open connection to BTdaemon\n");
		return err;
	}
	bt_register_packet_handler(packet_handler);
	bt_send_cmd(&btstack_set_power_mode, HCI_POWER_ON );
	run_loop_execute();
	bt_close();
	return 0;
}