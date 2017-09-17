import os
import glob
import time

os.system('modprobe w1-gpio')
os.system('modprobe w1-therm')

base_dir = '/sys/bus/w1/devices/'
device_folder1 = glob.glob(base_dir + '28-00047*')[0]
device_folder2 = glob.glob(base_dir + '28-0000065*')[0]
device_file1 = device_folder1 + '/w1_slave'
device_file2 = device_folder2 + '/w1_slave'

def read_temp_raw(probeNum):
    if probeNum == 1:
    	f = open(device_file1, 'r')
    else:
    	f = open(device_file2, 'r')
    lines = f.readlines()
    f.close()
    return lines

def read_temp(probeNum):
    if probeNum == 1:
    	lines = read_temp_raw(1)
    else:
    	lines = read_temp_raw(2)
    while lines[0].strip()[-3:] != 'YES':
        time.sleep(0.2)
        lines = read_temp_raw()
    equals_pos = lines[1].find('t=')
    if equals_pos != -1:
        temp_string = lines[1][equals_pos+2:]
        temp_c = float(temp_string) / 1000.0
        temp_f = temp_c * 9.0 / 5.0 + 32.0
        return temp_c, temp_f
	
	



print("Temps: ")
print(read_temp(1) + read_temp(2))