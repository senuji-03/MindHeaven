import sys
import re

def resolve_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        lines = f.readlines()
        
    out_lines = []
    in_conflict = False
    keep_this_block = False
    
    for line in lines:
        if line.startswith('<<<<<<< HEAD'):
            in_conflict = True
            keep_this_block = False # Drop HEAD block
            continue
            
        if in_conflict and line.startswith('======='):
            keep_this_block = True # Keep the incoming block
            continue
            
        if in_conflict and line.startswith('>>>>>>>'):
            in_conflict = False
            keep_this_block = False
            continue
            
        if not in_conflict:
            out_lines.append(line)
        elif in_conflict and keep_this_block:
            out_lines.append(line)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.writelines(out_lines)
    print(f"Brute-force resolved {filepath}")

for f in [
    r'c:\xampp\htdocs\MindHeaven\app\views\layouts\header.php',
    r'c:\xampp\htdocs\MindHeaven\app\views\Moderator\ModeratorDashboard.php',
    r'c:\xampp\htdocs\MindHeaven\app\controllers\ModeratorControl.php',
    r'c:\xampp\htdocs\MindHeaven\app\views\layouts\landing.php'
]:
    resolve_file(f)

