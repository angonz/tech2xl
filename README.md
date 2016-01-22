# tech2xl
Python script to extract info from Cisco devices commands and create an Excel file
Version 1.0
Author: Andrés González

Usage
-----

python tech2xl <output excel filename> <input text files>...

Example: 
>python tech2xl report.xls show_tech.txt

Requirements and installation
-----------------------------

Requires python 3.5
Requires xlwt-future library (download from https://pypi.python.org/pypi/xlwt-future)


How it works
------------

tech2xl parses the text of the input files looking for certain information. Then it creates an Excel file with this information organized in sheets.
At the input file, it will look for the command line to extract the hostname. For example, a line like this must be present:
  router#show tech

- Multiple outputs can be present in an input file, even from different devices. The script will detect the start of a new command with a line as indicated above.
- If the input comes from many devices, take care that the hostname is different.
- The script will detect the command to be interpreted. It will accept usual abbreviations (like "sh run" instead of "show running-config")
- It will accept line commands, as well as the same information within sections of a "show technical-support" command output

Commands (and sections of a "show technical-support") supported
---------------------------------------------------------------

- show version
- show running-config
- show interfaces
- show interfaces status
- show cdp neighbors
- show cdp neighbors detail
- show diag
- show inventory

Excel file output format
------------------------

The ouput will be an Excel file containing the following sheets:

- System: general information of each device
- Interfaces: information of each interface of each device
- CDP neighbors: information of neighbors detected by CDP

The sheets will contain the following information:

System sheet: 

- Name: hostname
- Model: part number of the device
- System ID: System serial number
- Mother ID: Motherboard serial number
- Image: filename of the system IOS

Interfaces sheet:

- Name: hostname
- Interface: full interface name
- Type: interface type (Ethernet, FastEthernet, GigabitEthernet, TenGigabit, Serial, Vlan, Tunnel, Port-channel)
- Number: interface numbering ([[module/]slot/]number)
- Description: configured interface description
- Status: up, down, administratively down, etc.
- Line protocol: up, down
- Hardware: interface hardware
- Mac address
- Encapsulation: ARPA, HDLC, Frame-relay, etc.
- Switchport mode: access or trunk for ethernet interfaces
- Access vlan: vlan for ethernet access ports
- Voice vlan: voice vlan if any for ethernet access ports
- IP address
- Mask bits: number of bits of mask
- Mask: mask in format A.B.C.D
- Network: network IP address extracted from the interface IP address and the mask
- Input errors: interface statitstics
- CRC: interface statitstics
- Frame errors: interface statitstics
- Overrun: interface statitstics
- Ignored: interface statitstics
- Output errors: interface statitstics
- Collisions: interface statitstics
- Interface resets: interface statitstics
- DLCI: for frame relay subinterfaces
- Duplex: duplex of ethernet interfaces (full, half, auto, a-full, a-half). a-full and a-half are auto duplex with duplex detected.
- Speed: speed of ethernet interfaces (10, 100, 1000, auto, a-10, a-100, a-1000, etc.). a-NNN are auto speed with speed detected.

CDP neigbors sheet:

- Name: hostname of local device
- Local interface: interface of local device
- Remote device: hostname of remote device detected at the local interface
- Remote interface: interface of remote device
- Remote device IP: IP address of remote device

Modules sheet:

- Name: hostname of local device
- Slot: main slot of module
- Subslot: where in main slot is the module
- Description: of the module
- Part number: of the module
- Serial number: of the module

