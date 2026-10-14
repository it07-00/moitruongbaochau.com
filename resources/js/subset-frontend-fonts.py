from pathlib import Path
from fontTools import subset

root = Path(__file__).resolve().parents[2]
ranges = [(0, 0x24F), (0x300, 0x36F), (0x1E00, 0x1EFF),
          (0x2000, 0x206F), (0x20A0, 0x20CF), (0x2122, 0x2122)]

for source in (root / 'public/assets/fonts').glob('SVN-Poppins-*.ttf'):
    options = subset.Options()
    options.flavor = 'woff'
    font = subset.load_font(str(source), options)
    subsetter = subset.Subsetter(options=options)
    subsetter.populate(unicodes=[codepoint for start, end in ranges
                                for codepoint in range(start, end + 1)])
    subsetter.subset(font)
    target = source.with_name(source.stem + '.subset.woff')
    subset.save_font(font, str(target), options)
    print(f'{target.name}: {target.stat().st_size} bytes')
