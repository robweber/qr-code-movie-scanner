# Generates QR codes from a list
import argparse
import glob
import os
import os.path
import qrcode
import urllib.parse
from kodijson import Kodi

# generates a qr code for the given title
def create_qr_code(base_url, title):

    qr = qrcode.QRCode(version=1)
    qr.add_data(f"{base_url}?title={ urllib.parse.quote_plus(title) }")
    qr.make(fit=True)
    img = qr.make_image(fill='black', back_color='white')

    save_path = os.path.join('images', f"{title}.png")
    img.save(save_path)

def purge_directory():
    files = glob.glob('images/*.png')

    for f in files:
        os.remove(f)

def check_exists(title):
    # try and find this movie in the database
    result = kodi.VideoLibrary.GetMovies({"filter":{"operator": "is", "field": "title", "value": title}})

    return result['result']['limits']['total']

# parse in the arguments
parser = argparse.ArgumentParser(description='QR Code Generator')
parser.add_argument('-i', '--input', required=True, type=argparse.FileType('r'))
parser.add_argument('-u', '--base_url', required=True, type=str)
parser.add_argument('-k', '--kodi', required=True, type=str)
args = parser.parse_args()

# clear out the images directory
purge_directory()

# create Kodi communicator
kodi = Kodi(f"http://{args.kodi}/jsonrpc")

# read in the titles
titles = args.input.readlines()

# for each title generate the qr code image
print(f"Generating QR Codes for {len(titles)} titles")
for t in titles:
    t_fixed = t.replace('\n', '')
    if(check_exists(t_fixed)):
        create_qr_code(args.base_url, t_fixed)
    else:
        print(f"{t_fixed} does not exist in Kodi DB")

print("QR Code genreation complete")
