import os

target_dir = "../passport"

os.makedirs(target_dir, exist_ok=True)

for i in range(1, 1001):
    folder_name = f"{i:04d}"
    folder_path = os.path.join(target_dir, folder_name)

    if not os.path.exists(folder_path):
        os.makedirs(folder_path)

print("文件夹创建完成！")
