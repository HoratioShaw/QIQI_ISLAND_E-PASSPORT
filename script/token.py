import random
import string

def generate_token(length=12):
    chars = string.ascii_letters + string.digits
    return ''.join(random.choices(chars, k=length))

with open(".env", "w") as env_file, open("links.txt", "w") as links_file:
    for i in range(1, 1001):
        token_id = f"{i:04d}"
        token_value = generate_token()

        env_file.write(f"TOKEN_{token_id}={token_value}\n")

        link = f"http://passport.mikey.horatio.cn/?id={token_id}&token={token_value}\n"
        links_file.write(link)

print(".env 和 links.txt 文件已生成！")
