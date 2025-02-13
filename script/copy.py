import os
import shutil

# 源文件夹路径
source_dir = '../passport/template'
# 目标根文件夹路径
target_root_dir = '../passport'

# 遍历源文件夹中的文件
for filename in os.listdir(source_dir):
    # 排除指定的文件（avatar.jpg 和 .env）
    if filename == 'avatar.jpg':
        continue

    source_file_path = os.path.join(source_dir, filename)

    # 确保源文件存在且是文件
    if os.path.isfile(source_file_path):
        # 遍历目标根文件夹下的所有子文件夹
        for subfolder in os.listdir(target_root_dir):
            target_folder_path = os.path.join(target_root_dir, subfolder)

            # 确保这是一个目录
            if os.path.isdir(target_folder_path):
                target_file_path = os.path.join(target_folder_path, filename)

                # 检查目标文件夹中是否存在 .env 文件
                env_file_path = os.path.join(target_folder_path, '.env')
                if not os.path.exists(env_file_path):  # 只有当 .env 文件不存在时才复制
                    # 复制文件并覆盖目标文件夹中的同名文件
                    shutil.copy2(source_file_path, target_file_path)

print("文件复制完成！")
