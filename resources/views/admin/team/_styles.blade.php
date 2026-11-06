<style>
    .alert-error {
        display: flex; align-items: center; gap: 10px;
        background: rgba(220,38,38,.08); border: 1px solid rgba(220,38,38,.28); color: #dc2626;
        border-radius: 13px; padding: 12px 16px; font-size: 13px; font-weight: 700; margin-bottom: 18px;
    }
    .a-btn.red { background: linear-gradient(135deg, #dc2626, #ef4444); box-shadow: 0 12px 26px -10px rgba(220,38,38,.55); }
    .btn-mini {
        display: inline-flex; align-items: center; gap: 6px;
        border: 1.5px solid rgba(5,150,105,.25); cursor: pointer; font-family: inherit; text-decoration: none;
        background: #fff; color: #1f4234; font-weight: 700; font-size: 12px;
        padding: 7px 13px; border-radius: 10px; transition: all .2s;
    }
    .btn-mini:hover { border-color: #059669; background: rgba(5,150,105,.06); transform: translateY(-1px); }
    .btn-mini.red { border-color: rgba(220,38,38,.3); background: rgba(220,38,38,.06); color: #dc2626; }
    .btn-mini.red:hover { background: rgba(220,38,38,.12); }
    .btn-mini.off { opacity: .55; cursor: not-allowed; transform: none; }
    .pill.gold { background: rgba(251,191,36,.14); color: #b45309; border-color: rgba(251,191,36,.35); }
    .pill.green { background: rgba(5,150,105,.1); color: #047857; border-color: rgba(5,150,105,.25); }
    .tag-me, .tag-lock { display: inline-block; padding: 2px 9px; border-radius: 999px; font-size: 11px; font-weight: 700; margin-left: 6px; }
    .tag-me { background: rgba(22,163,74,.12); color: #16a34a; }
    .tag-lock { background: rgba(180,83,9,.12); color: #b45309; }
    .preset-row { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
    .pm-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 250px), 1fr)); gap: 12px; }
    .pm-card {
        border: 1.5px solid rgba(5,150,105,.16); border-radius: 14px; padding: 14px;
        background: linear-gradient(180deg, #fff, #f7fcf9); transition: border-color .2s, box-shadow .2s;
    }
    .pm-card:hover { border-color: rgba(5,150,105,.35); box-shadow: 0 10px 24px -14px rgba(6,78,59,.3); }
    .pm-head { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px dashed rgba(5,150,105,.2); }
    .pm-head b { font-size: 13px; color: #12261d; }
    .pm-head-r { display: inline-flex; align-items: center; gap: 8px; }
    .pm-count { font-size: 9.5px; font-weight: 800; padding: 2px 8px; border-radius: 999px; background: rgba(5,150,105,.1); color: #047857; white-space: nowrap; }
    .pm-all { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: #059669; cursor: pointer; user-select: none; }
    .pm-row { display: flex; align-items: center; gap: 9px; padding: 5px 2px; font-size: 12.5px; color: #1f4234; cursor: pointer; border-radius: 8px; }
    .pm-row:hover { background: rgba(5,150,105,.07); }
    .pm-group { font-size: 9px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: #6b8a7a; padding: 8px 2px 2px; }
</style>
