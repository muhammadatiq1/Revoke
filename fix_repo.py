import os
import shutil
import subprocess
import sys

repo_path = r"C:\Users\Atif Traders\OneDrive\Desktop\Revoke"
revoke_path = os.path.join(repo_path, "revoke")
git_path = os.path.join(repo_path, ".git")

try:
    os.chdir(repo_path)
    
    # Step 1: Remove merge state files
    merge_files = [".git/MERGE_HEAD", ".git/MERGE_MSG", ".git/MERGE_MODE", ".git/.MERGE_MSG.swp"]
    for f in merge_files:
        try:
            os.remove(f)
        except:
            pass
    
    # Step 2: Move files from revoke folder to root
    if os.path.isdir(revoke_path):
        for item in os.listdir(revoke_path):
            src = os.path.join(revoke_path, item)
            dst = os.path.join(repo_path, item)
            if os.path.exists(dst):
                if os.path.isdir(dst):
                    shutil.rmtree(dst)
                else:
                    os.remove(dst)
            shutil.move(src, dst)
        shutil.rmtree(revoke_path)
    
    # Step 3: Git operations
    subprocess.run(["git", "reset", "--hard", "HEAD"], capture_output=True)
    subprocess.run(["git", "clean", "-fd"], capture_output=True)
    subprocess.run(["git", "add", "."], capture_output=True)
    subprocess.run(["git", "commit", "-m", "Restructure: move code to root"], capture_output=True)
    subprocess.run(["git", "branch", "-M", "master", "main"], capture_output=True)
    result = subprocess.run(["git", "push", "origin", "main", "--force"], capture_output=True, text=True)
    
    print("✓ Repository restructured successfully!")
    print(f"Output: {result.stdout}")
    if result.stderr:
        print(f"Info: {result.stderr}")
        
except Exception as e:
    print(f"Error: {str(e)}", file=sys.stderr)
    sys.exit(1)
