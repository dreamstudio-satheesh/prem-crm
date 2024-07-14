#!/bin/bash

# Find and count PHP and Blade files, excluding specified directories
total_files=$(find . -type f \( -name '*.php' -o -name '*.blade.php' \) ! -path "./vendor/*" ! -path "./public/*" ! -path "./.git/*" | wc -l)
total_lines=$(find . -type f \( -name '*.php' -o -name '*.blade.php' \) ! -path "./vendor/*" ! -path "./public/*" ! -path "./.git/*" | xargs wc -l | grep total | awk '{print $1}')

echo "Total files: $total_files"
echo "Total lines of code: $total_lines"
