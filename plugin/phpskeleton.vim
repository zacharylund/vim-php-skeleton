au BufNewFile *.php call setline('.', systemlist(expand("<sfile>:h:h/bin/phpskeleton.php").' '.expand('%:p')))
