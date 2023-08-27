# Generates QR codes from a list
import argparse
import qrcode

website = "https://www.google.com"

qr = qrcode.QRCode(version=3)
qr.add_data(website)
qr.make(fit=True)
img = qr.make_image(fill='black', back_color='white')
img.save('qr.png')
