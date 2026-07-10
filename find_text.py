import re
import base64
try:
    import pytesseract
except ImportError:
    import sys
    import subprocess
    sys.exit(1)
from PIL import Image
import io

with open('c:/xampp/htdocs/Hair_Studio_Management/resources/views/stylist/designer-svg.blade.php', 'r') as f:
    content = f.read()

m = re.search(r'id="WhatsApp_Image_2026-05-24_at_11\.47\.18_PM"[^>]*xlink:href="data:img/png;base64,([^"]+)"', content)
if m:
    b64 = m.group(1)
    img_data = base64.b64decode(b64)
    img = Image.open(io.BytesIO(img_data))
    
    # Optional: resize or process image if pytesseract needs it
    # Just to be safe, save the image so we can inspect it if needed
    img.save('c:/xampp/htdocs/Hair_Studio_Management/scratch_img.png')

    try:
        data = pytesseract.image_to_data(img, output_type=pytesseract.Output.DICT)
        for i in range(len(data['text'])):
            text = data['text'][i].strip()
            if text and ('Booked' in text or 'Seat' in text or 'Available' in text or 'Time' in text):
                print(f"Found '{text}' at X: {data['left'][i]}, Y: {data['top'][i]}, W: {data['width'][i]}, H: {data['height'][i]}")
    except Exception as e:
        print("Tesseract failed:", e)
else:
    print('Image not found')
