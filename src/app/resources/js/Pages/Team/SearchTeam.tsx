import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';
import { PageProps } from '@/types';

interface Prefecture {
    value: number;
    label: string;
}

interface Team {
    id: number;
    name: string;
    code: string;
    logo?: string;
    address: string;
    extension?: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props extends Record<string, unknown> {
    prefectures: Prefecture[];
    teams: { data: Team[]; links: PaginationLink[]; total: number };
    filters: { prefecture?: number; address?: string; teamName?: string };
    myTeam?: any;
}

export default function SearchTeam({ teams, filters, prefectures }: PageProps<Props>) {
    const [prefecture, setPrefecture] = React.useState(filters.prefecture || '');
    const [address, setAddress] = React.useState(filters.address || '');
    const [teamName, setTeamName] = React.useState(filters.teamName || '');

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        router.get(route('team.list'), { prefecture, address, teamName });
    };

    return (
        <AuthenticatedLayout>
            <Head title="招待チームを検索" />

            <div className="max-w-5xl mx-auto px-6 py-10">
                <div className="bg-white shadow-lg rounded-xl p-8">
                    <h2 className="text-xl font-semibold mb-4 border-b pb-2">招待チームを検索</h2>
                    <form onSubmit={submit} className="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label className="block mb-1 text-sm font-medium" htmlFor="prefecture">都道府県</label>
                            <select
                                id="prefecture"
                                name="prefecture"
                                value={prefecture}
                                onChange={(e) => setPrefecture(e.target.value)}
                                className="block w-full border-gray-300 rounded-md shadow-sm"
                            >
                                <option value="">選択してください</option>
                                {prefectures.map((pref) => (
                                    <option key={pref.value} value={pref.value}>{pref.label}</option>
                                ))}
                            </select>
                        </div>

                        <div>
                            <label className="block mb-1 text-sm font-medium" htmlFor="address">住所（市町村区）</label>
                            <input
                                id="address"
                                name="address"
                                type="text"
                                value={address}
                                onChange={(e) => setAddress(e.target.value)}
                                className="block w-full border-gray-300 rounded-md shadow-sm"
                            />
                        </div>

                        <div>
                            <label className="block mb-1 text-sm font-medium" htmlFor="teamName">チーム名</label>
                            <input
                                id="teamName"
                                name="teamName"
                                type="text"
                                value={teamName}
                                onChange={(e) => setTeamName(e.target.value)}
                                className="block w-full border-gray-300 rounded-md shadow-sm"
                            />
                        </div>

                        <button type="submit" className="col-span-full bg-indigo-500 hover:bg-indigo-600 text-white rounded-md py-2 font-semibold">
                            検索する
                        </button>
                    </form>
                </div>

                <div className="border-t border-gray-200 mt-10 pt-6">
                    <h3 className="text-lg font-semibold mb-4">検索結果<span className="text-sm text-gray-600 mb-4"> :  {teams.total} 件</span></h3>
                    {/* チーム一覧 */}
                    <div className="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        {teams.data.length > 0 ? (
                            teams.data.map((team) => (
                                <div key={team.id} className="bg-white shadow-lg rounded-lg p-4 flex flex-col items-center min-h-[160px] w-full">
                                    {team.logo ? (
                                        <img src={team.logo} className="w-20 h-20 rounded-full object-cover mb-3" alt="team logo" />
                                    ) : (
                                        <div className="w-20 h-20 bg-gray-200 rounded-full mb-3"></div>
                                    )}
                                    {/* チーム名 */}
                                    <div className="font-semibold mb-1 text-center text-sm">{team.name}</div>
                                    {/* 住所 */}
                                    {team.address && (
                                        <div className="text-gray-500 text-[10px] sm:text-xs text-center">{team.address}</div>
                                    )}
                                    {/* マッチングボタン */}
                                    <Link href={route('team.invite_game.index', team.id)}
                                        className="mt-2 px-3 py-1 bg-gray-100 text-gray-700 text-[10px] sm:text-xs font-medium rounded-md hover:bg-gray-200 transition-all duration-150">
                                        マッチする
                                    </Link>
                                </div>
                            ))
                        ) : (
                            <div className="col-span-full text-center text-gray-600">該当するチームが登録されていません。</div>
                        )}
                    </div>

                    {/* ページネーション */}
                    {teams.links && (
                        <div className="mt-6 flex justify-center gap-1 flex-wrap text-sm">
                            {teams.links.filter(link => link.url !== null).map((link, index) => (
                                <span
                                    key={index}
                                    className={`px-2 py-1 rounded-md border ${link.active ? 'bg-indigo-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}`}
                                >
                                    {link.active ? (
                                        <span dangerouslySetInnerHTML={{ __html: link.label }} />
                                    ) : (
                                        <Link href={link.url || '#'} dangerouslySetInnerHTML={{ __html: link.label }} />
                                    )}
                                </span>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
