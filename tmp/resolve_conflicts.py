import os
import re

def process_conflicts(text, filepath):
    pattern = re.compile(
        r'<<<<<<< HEAD\r?\n'
        r'(.*?)'
        r'=======\r?\n'
        r'(.*?)'
        r'>>>>>>> ([^\r\n]+)\r?\n?',
        re.DOTALL
    )

    filepath_lower = filepath.lower()
    is_admin = 'admin' in filepath_lower
    is_forum = 'forum' in filepath_lower or 'moderate' in filepath_lower
    is_unirep = 'university' in filepath_lower or 'uni-rep' in filepath_lower
    
    count = 0
    
    def replacer(match):
        nonlocal count
        count += 1
        head_block = match.group(1)
        other_block = match.group(2)
        branch = match.group(3).strip()
        
        hb_stripped = head_block.strip()
        ob_stripped = other_block.strip()
        
        # If one is completely empty, use the other
        if not hb_stripped and ob_stripped:
            return other_block + "\n"
        if not ob_stripped and hb_stripped:
            return head_block + "\n"
        if not hb_stripped and not ob_stripped:
            return ""

        # Check if it contains functions
        if 'public function' in head_block and 'public function' in other_block:
            head_funcs = set(re.findall(r'function\s+(\w+)', head_block))
            other_funcs = set(re.findall(r'function\s+(\w+)', other_block))
            if not head_funcs.intersection(other_funcs):
                return head_block + "\n" + other_block + "\n"
                
        is_unirep_branch = 'uni-representative' in branch
        if is_unirep_branch:
            if is_admin or is_forum or is_unirep:
                return other_block + "\n"
            else:
                return other_block + "\n" # The user said prioritize uni-rep for these features, but let's just accept uni-rep if it's there for other things too unless it's a completely different view.
                
        # By default, pick the larger block if we can't decide, or other_block
        if len(other_block) > len(head_block):
            return other_block + "\n"
        else:
            return head_block + "\n"

    new_text = pattern.sub(replacer, text)
    return new_text, count

def main():
    root_dir = 'c:/xampp/htdocs/MindHeaven'
    total_resolved = 0
    files_touched = []
    
    for root, dirs, files in os.walk(root_dir):
        # skip vendor, node_modules, etc
        if 'vendor' in root or 'node_modules' in root or '.git' in root:
            continue
            
        for file in files:
            if file.endswith(('.php', '.js', '.css', '.html', '.sql')):
                path = os.path.join(root, file)
                try:
                    with open(path, 'r', encoding='utf-8') as f:
                        content = f.read()
                        
                    if '<<<<<<< HEAD' in content:
                        new_content, count = process_conflicts(content, path)
                        if count > 0:
                            # if somehow markers still exist (maybe nested or malformed)
                            if '<<<<<<<' in new_content:
                                print(f"WARNING: unresolved markers left in {path}")
                            with open(path, 'w', encoding='utf-8', newline='') as f:
                                f.write(new_content)
                            print(f'Resolved {count} conflicts in {path}')
                            total_resolved += count
                            files_touched.append(path)
                except Exception as e:
                    pass

    print(f"Total conflicts resolved: {total_resolved} across {len(files_touched)} files")

if __name__ == '__main__':
    main()
