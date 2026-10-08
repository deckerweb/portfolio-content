#!/usr/bin/env python3
"""Build a clean plugin-only distribution from explicitly allowed runtime files."""
from pathlib import Path
import argparse,re,zipfile
root=Path(__file__).resolve().parents[1]
parser=argparse.ArgumentParser();parser.add_argument('--output',type=Path,required=True);args=parser.parse_args();out=args.output.resolve();out.mkdir(parents=True,exist_ok=True)
version=re.search(r'\* Version: (\S+)',(root/'portfolio-content.php').read_text()).group(1)
allowed_roots={'portfolio-content.php','index.php','uninstall.php','LICENSE','readme.txt','readme-de.txt','SECURITY.md','SECURITY-de.md'}
assets={'assets/icon.svg','assets/icon-128x128.png','assets/icon-256x256.png','assets/banner-1544x500.png','assets/banner-772x250.png','assets/banner-de-1544x500.png','assets/banner-de-772x250.png','assets/css/admin.css','assets/documentation.js','assets/template.js'}
with zipfile.ZipFile(out/f'portfolio-content-{version}.zip','w',zipfile.ZIP_DEFLATED) as archive:
 for file in sorted(root.rglob('*')):
  if not file.is_file() or out in file.resolve().parents:continue
  rel=file.relative_to(root);name=rel.as_posix()
  if any(part.startswith('.') for part in rel.parts):continue
  if not (name in allowed_roots or name in assets or rel.parts[0] in {'includes','languages'} or (rel.parts[0]=='docs' and file.suffix=='.txt')):continue
  if file.suffix=='.pyc' or '__pycache__' in rel.parts:continue
  archive.write(file,'portfolio-content/'+name)
print('Built plugin-only ZIP for '+version)
