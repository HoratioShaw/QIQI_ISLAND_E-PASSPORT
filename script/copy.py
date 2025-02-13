import os
import shutil

source_folder = os.path.abspath("../passport/template")
target_parent_folder = os.path.abspath("../passport")

excluded_files = [".env.example"]

source_files = []
for root, dirs, files in os.walk(source_folder):
    for file in files:
        if file not in excluded_files:
            source_files.append(os.path.join(root, file))

target_folders = []
for item in os.listdir(target_parent_folder):
    item_path = os.path.join(target_parent_folder, item)
    if os.path.isdir(item_path) and item_path != source_folder:
        target_folders.append(item_path)

for target_folder in target_folders:
    for source_file in source_files:
        file_name = os.path.basename(source_file)
        target_file = os.path.join(target_folder, file_name)

        if file_name == ".env":
            env_file_path = os.path.join(target_folder, ".env")
            if os.path.exists(env_file_path):
                continue
            else:
                shutil.copy2(source_file, target_file)
                folder_name = os.path.basename(target_folder)
                with open(target_file, 'r+') as f:
                    lines = f.readlines()
                    f.seek(0)
                    for line in lines:
                        if line.startswith("PASSPORT_NUMBER="):
                            line = f"PASSPORT_NUMBER=NO.{folder_name}\n"
                        f.write(line)
                    f.truncate()
        else:
            shutil.copy2(source_file, target_file)

print("文件复制完成！")