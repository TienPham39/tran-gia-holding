const fs = require('fs');
const path = require('path');

const hotFile = path.join(__dirname, '..', 'public', 'hot');

try {
  if (fs.existsSync(hotFile)) {
    fs.unlinkSync(hotFile);
    console.log('✓ Removed public/hot file');
  } else {
    console.log('✓ public/hot file does not exist (already clean)');
  }
} catch (error) {
  console.error('Error removing hot file:', error.message);
  process.exit(1);
}

