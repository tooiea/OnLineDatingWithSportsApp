import CommonHeader from '@/Components/CommonHeader';
import MobileFooterNav from '@/Components/MobileFooterNav';
import GuestFooterNav from '@/Components/GuestFooterNav';

interface Props {
  isAuthenticated: boolean;
  routes: {
    current: string;
    login: string;
    logout: string;
    home: string;
    my_profile: string;
    myteam_index: string;
    myteam_detail: string;
    team_list: string;
    temp_register_team: string;
  };
}

export default function TopPage({ isAuthenticated, routes }: Props) {
  const currentYear = new Date().getFullYear();

  return (
    <div className="min-h-screen bg-white text-gray-800 font-sans pb-20 pt-16">
      <CommonHeader routes={routes} />

      {/* ヒーローセクション */}
      <section className="text-center py-10 bg-gradient-to-b from-blue-100 to-white">
        <h1 className="text-xl font-bold mb-4 text-blue-800">
          スポーツが人を寄り添わせ、<br className="sm:hidden" />優しさで温かな絆を紡ぐ
        </h1>
        <div className="flex justify-center gap-4">
          {isAuthenticated ? (
            <a
              href={routes.team_list}
              className="bg-blue-600 text-white px-4 py-2 rounded-full"
            >
              チームを探す
            </a>
          ) : (
            <a
              href={routes.temp_register_team}
              className="bg-green-600 text-white px-4 py-2 rounded-full"
            >
              登録して始める
            </a>
          )}
        </div>
      </section>

      {/* 特長セクション */}
      <section className="px-4 py-10 bg-gray-50">
        <h2 className="text-base font-bold text-center mb-6 text-blue-800">OLDWS の使い方</h2>
        <div className="max-w-xl mx-auto space-y-6">
          <FeatureItem icon="⚽" title="気軽に試合へ参加" desc="チームに招待されて、気軽にスポーツの試合に参加できます。" />
          <FeatureItem icon="🧑‍🤝‍🧑" title="スポーツで仲間づくり" desc="共通のスポーツを通じて、自然と会話や交流が生まれます。" />
          <FeatureItem icon="📆" title="日程のやりとりも簡単" desc="試合日程の調整もスムーズ。カレンダー形式で提案＆返信が可能です。" />
        </div>
      </section>

      {/* 招待・登録選択：未ログイン時のみ */}
      {!isAuthenticated && (
        <section className="grid grid-cols-1 sm:grid-cols-2 gap-4 px-4 pb-10 max-w-4xl mx-auto">
          <div className="bg-blue-50 p-4 rounded-xl text-center shadow-sm">
            <h3 className="font-bold mb-2 text-blue-800">チームから招待された方</h3>
            <p className="text-sm text-gray-700">招待URLより登録後、チームに参加できます</p>
          </div>
          <div className="bg-blue-50 p-4 rounded-xl text-center shadow-sm">
            <h3 className="font-bold mb-2 text-blue-800">チームを登録して始める</h3>
            <a
              href={routes.temp_register_team}
              className="bg-green-600 text-white w-full inline-block py-2 mt-2 rounded"
            >
              仮登録する
            </a>
          </div>
        </section>
      )}

      {/* フッター */}
      <footer className="text-center text-xs text-gray-500 py-4 border-t">
        © {currentYear} OLDWS / お問い合わせ | 利用規約 | プライバシー
      </footer>

      {/* スマホ用フッターメニュー */}
      {isAuthenticated ? (
        <MobileFooterNav routes={routes} />
      ) : (
        <GuestFooterNav routes={routes} />
      )}
    </div>
  );
}

function FeatureItem({ icon, title, desc }: { icon: string, title: string, desc: string }) {
  return (
    <div className="bg-white border rounded-xl p-4 flex items-start gap-4">
      <div className="text-2xl">{icon}</div>
      <div>
        <h4 className="font-semibold mb-1 text-blue-800">{title}</h4>
        <p className="text-sm text-gray-700">{desc}</p>
      </div>
    </div>
  );
}
