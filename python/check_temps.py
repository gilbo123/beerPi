import sys
import os
import time
import RPi.GPIO as GPIO

temp_amb = sys.argv[1]
temp_liq = sys.argv[2]
compPin = 22

def setup_io():
    GPIO.setwarnings(False)
    GPIO.setmode(GPIO.BCM)
    GPIO.setup(compPin, GPIO.OUT)


def trigger_once():
    GPIO.output(compPin, GPIO.LOW)
    time.sleep(3)
    GPIO.output(compPin, GPIO.HIGH)
    
def check_temp():
    #check if the compressor is running
    state = GPIO.input(compPin)  
    print state 
    
    #if compressor on (Pull down)
    if state == 0:
        #check temp threshold for turning off
        if float(temp_amb) < 19:
            #turn off compressor
            print("turning off..")
            GPIO.output(compPin, GPIO.HIGH)
        else:
            print("No action..")
    #else if compressor off
    elif state == 1:
        #check temp threshold for turning on
        if float(temp_amb) > 21:
            #turn on compressor
            print("turning on...")
            GPIO.output(compPin, GPIO.LOW)
        else:
            print("No action..")

setup_io()
# trigger_once()
check_temp()
print("done.." + temp_amb + temp_liq) 