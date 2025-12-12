const fs = require('fs');
const path = require('path');

const filePath = path.resolve(__dirname, '../public/hot');
if (fs.existsSync(filePath)) {
  fs.unlinkSync(filePath);
  console.log('Removed hot file');
}
