<?php
\App\Models\Chair::firstOrCreate(['id'=>6], ['name'=>'Chair 6', 'status'=>'available']);
\App\Models\Chair::firstOrCreate(['id'=>7], ['name'=>'Chair 7', 'status'=>'available']);
echo "Seeded!";
