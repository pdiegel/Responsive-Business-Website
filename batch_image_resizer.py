from PIL import Image


def resize_image(input_path, output_path, size):
    with Image.open(input_path) as img:
        width, height = size
        img = img.resize((width, height))
        img.save(output_path)


base_url = "images/"
images_to_resize = {
    "travel": [".webp", (400, 267), (844, 563)],
    "grow": [".webp", (400, 267), (844, 563)],
    "logo": [".webp", (100, 100)],
}

for image_name, sizes in images_to_resize.items():
    extension = sizes.pop(0)
    input_path = f"{base_url}{image_name}{extension}"
    for size in sizes:
        output_path = f"{base_url}{image_name}-{size[0]}x{size[1]}{extension}"
        resize_image(input_path, output_path, size)
