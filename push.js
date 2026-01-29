const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const repoPath = 'C:\\Users\\Atif Traders\\OneDrive\\Desktop\\Revoke';

try {
  // Remove merge state files
  const gitPath = path.join(repoPath, '.git');
  const mergeFiles = ['MERGE_HEAD', 'MERGE_MSG', 'MERGE_MODE', '.MERGE_MSG.swp', 'AUTO_MERGE'];
  
  mergeFiles.forEach(file => {
    const filePath = path.join(gitPath, file);
    if (fs.existsSync(filePath)) {
      fs.unlinkSync(filePath);
      console.log(`Deleted ${file}`);
    }
  });
  
  process.chdir(repoPath);
  
  // Reset and clean
  execSync('git reset --hard HEAD', { stdio: 'inherit' });
  execSync('git clean -fd', { stdio: 'inherit' });
  
  // Move revoke files to root
  const revokePath = path.join(repoPath, 'revoke');
  if (fs.existsSync(revokePath)) {
    fs.readdirSync(revokePath).forEach(item => {
      const src = path.join(revokePath, item);
      const dst = path.join(repoPath, item);
      
      if (fs.existsSync(dst)) {
        fs.rmSync(dst, { recursive: true, force: true });
      }
      fs.renameSync(src, dst);
    });
    fs.rmdirSync(revokePath);
    console.log('Files moved to root');
  }
  
  // Git commit
  execSync('git add .', { stdio: 'inherit' });
  execSync('git commit -m "Move code to root directory" --allow-empty', { stdio: 'inherit' });
  
  // Push
  console.log('Pushing to GitHub...');
  execSync('git push origin main --force', { stdio: 'inherit' });
  
  console.log('\n✓ Repository updated successfully!');
} catch (error) {
  console.error('Error:', error.message);
  process.exit(1);
}
