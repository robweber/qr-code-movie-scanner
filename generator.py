# Generates QR codes from a list
import argparse
import os.path
import qrcode
import urllib.parse

# generates a qr code for the given title
def create_qr_code(base_url, title):

    qr = qrcode.QRCode(version=3)
    qr.add_data(f"{base_url}?title={ urllib.parse.quote_plus(title) }")
    qr.make(fit=True)
    img = qr.make_image(fill='black', back_color='white')

    save_path = os.path.join('images', f"{title}.png")
    img.save(save_path)

# parse in the arguments
parser = argparse.ArgumentParser(description='QR Code Generator')
parser.add_argument('-i', '--input', required=True, type=argparse.FileType('r'))
parser.add_argument('-u', '--base_url', required=True, type=str)

args = parser.parse_args()

# read in the titles
titles = args.input.readlines()

# for each title generate the qr code image
for t in titles:
    create_qr_code(args.base_url, t.replace('\n', ''))
