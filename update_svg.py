import os

new_svg_path = r'C:\Users\Admin\Downloads\chairs 8 (1).svg'
blade_path = r'c:\xampp\htdocs\Hair_Studio_Management\resources\views\stylist\designer-svg.blade.php'

# Read new SVG static parts (lines 1 to 15)
with open(new_svg_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()
static_svg = ''.join(lines[:15])

# Add the green filter
filter_def = '''
    <filter id="chair-green" x="-20%" y="-20%" width="140%" height="140%">
      <feFlood flood-color="#17b081" result="flood"/>
      <feComposite in="flood" in2="SourceAlpha" operator="in" result="mask"/>
      <feBlend in="mask" in2="SourceGraphic" mode="multiply"/>
      <feDropShadow dx="0" dy="4" stdDeviation="8" flood-color="#17b081" flood-opacity="0.6"/>
    </filter>
'''
static_svg += filter_def

# The rest of the blade file
blade_logic = r'''
    @php
        $multiChairSplit = $avail['status'] === 'multi_chair' ? $avail['schedule'] : [];
        $assignedChair = $avail['status'] === 'single_chair' ? $avail['chair_id'] : null;

        $allChairs = \App\Models\Chair::pluck('name', 'id')->toArray();
        $chairData = [
            1 => ['x' => 365, 'y' => 1019, 'href' => '#image'],
            2 => ['x' => 365, 'y' => 1529, 'href' => '#image'],
            3 => ['x' => 365, 'y' => 2039, 'href' => '#image'],
            4 => ['x' => 1115, 'y' => 1529, 'href' => '#image-2'],
            5 => ['x' => 1115, 'y' => 1988, 'href' => '#image-2'],
            6 => ['x' => 1523, 'y' => 1529, 'href' => '#image'],
            7 => ['x' => 1523, 'y' => 1988, 'href' => '#image']
        ];
    @endphp

    @foreach($chairData as $cid => $data)
        @php
            $isMultiAssigned = in_array($cid, $multiChairSplit);
            $isSelected = ($avail['status'] === 'single_chair' && $cid == $assignedChair) || ($avail['status'] === 'multi_chair' && $isMultiAssigned);
            $chairName = $allChairs[$cid] ?? 'Chair ' . $cid;
        @endphp
        
        <use id="chair-{{ $cid }}" x="{{ $data['x'] }}" y="{{ $data['y'] }}" xlink:href="{{ $data['href'] }}" @if($isSelected) filter="url(#chair-green)" @endif/>
        <text x="{{ $data['x'] > 1000 ? $data['x'] + 430 : $data['x'] - 50 }}" y="{{ $data['y'] + 200 }}" font-size="60" font-family="Arial, sans-serif" fill="#333333" font-weight="bold" text-anchor="{{ $data['x'] > 1000 ? 'start' : 'end' }}" style="pointer-events:none;">{{ $loop->iteration }}</text>
    @endforeach

    @foreach($chairData as $cid => $data)
        @php
            $isMultiAssigned = in_array($cid, $multiChairSplit);
            $isSelected = ($avail['status'] === 'single_chair' && $cid == $assignedChair) || ($avail['status'] === 'multi_chair' && $isMultiAssigned);
            $chairName = $allChairs[$cid] ?? 'Chair ' . $cid;
        @endphp
        
        @if($isSelected)
            @php
                if($avail['status'] === 'multi_chair') {
                    $hourIndex = array_search($cid, $multiChairSplit);
                    $startHour = \Carbon\Carbon::parse(session('stylist_booking.start_time'))->addHours($hourIndex)->format('g:i A');
                    $endHour = \Carbon\Carbon::parse(session('stylist_booking.start_time'))->addHours($hourIndex + 1)->format('g:i A');
                    $hourLabel = ($hourIndex == 0) ? '1st Hour' : (($hourIndex == 1) ? '2nd Hour' : 'Hour '.($hourIndex+1));
                } else {
                    $startHour = \Carbon\Carbon::parse(session('stylist_booking.start_time'))->format('g:i A');
                    $endHour = \Carbon\Carbon::parse(session('stylist_booking.end_time'))->format('g:i A');
                    $hourLabel = 'Full Duration';
                }
            @endphp
            <rect x="{{ $data['x'] - 20 }}" y="{{ $data['y'] - 120 }}" width="560" height="100" fill="#fff" rx="16" filter="drop-shadow(0px 8px 20px rgba(0,0,0,0.15))"/>
            <text x="{{ $data['x'] + 10 }}" y="{{ $data['y'] - 75 }}" font-size="32" fill="#111" font-weight="bold">{{ $chairName }}: {{ $startHour }} - {{ $endHour }}</text>
            <text x="{{ $data['x'] + 10 }}" y="{{ $data['y'] - 40 }}" font-size="28" fill="#666">({{ $hourLabel }})</text>
        @endif
    @endforeach
    @if($avail['status'] === 'multi_chair' && count($multiChairSplit) > 1)
        <!-- Arrow Defs -->
        <defs>
            <marker id="arrowhead" markerWidth="15" markerHeight="10.5" refX="13.5" refY="5.25" orient="auto">
                <polygon points="0 0, 15 5.25, 0 10.5" fill="#17b081" />
            </marker>
        </defs>
        
        @for($i = 0; $i < count($multiChairSplit) - 1; $i++)
            @php
                $fromCid = $multiChairSplit[$i];
                $toCid = $multiChairSplit[$i+1];
                if (isset($chairData[$fromCid]) && isset($chairData[$toCid])) {
                    $fromData = $chairData[$fromCid];
                    $toData = $chairData[$toCid];
                    
                    // Chair center is roughly x + 204, y + 199
                    $fromX = $fromData['x'] + 204;
                    $fromY = $fromData['y'] + 199;
                    $toX = $toData['x'] + 204;
                    $toY = $toData['y'] + 199;
                }
            @endphp
            @if(isset($fromX))
                <!-- A nice thick dashed arrow -->
                <line x1="{{ $fromX }}" y1="{{ $fromY }}" x2="{{ $toX }}" y2="{{ $toY }}" stroke="#17b081" stroke-width="12" stroke-dasharray="24,14" marker-end="url(#arrowhead)" style="filter: drop-shadow(0px 4px 8px rgba(0,0,0,0.3));" />
            @endif
        @endfor
    @endif
</svg>
'''

full_content = static_svg + blade_logic

with open(blade_path, 'w', encoding='utf-8') as f:
    f.write(full_content)
print("Done updating designer-svg.blade.php")
