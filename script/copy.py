import os
import shutil

source_dir = '../passport/template'
target_root_dir = '../passport'

for filename in os.listdir(source_dir):
    if filename == 'avatar.jpg':
        continue

    source_file_path = os.path.join(source_dir, filename)

    if os.path.isfile(source_file_path):
        for subfolder in os.listdir(target_root_dir):
            target_folder_path = os.path.join(target_root_dir, subfolder)

            if os.path.isdir(target_folder_path):
                target_file_path = os.path.join(target_folder_path, filename)

                env_file_path = os.path.join(target_folder_path, '.env')
                if not os.path.exists(env_file_path):
                    shutil.copy2(source_file_path, target_file_path)

print("文件复制完成！")
