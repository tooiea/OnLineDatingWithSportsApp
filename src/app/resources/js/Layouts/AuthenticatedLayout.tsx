import { PropsWithChildren, ReactNode, useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';

export default function AuthenticatedLayout({
    header,
    children,
}: PropsWithChildren<{ header?: ReactNode }>) {
    const { url, component } = usePage();
    const user = usePage().props.auth.user;

    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

    const isActive = (routeName: string) => route().current(routeName);

    return (
        <div className="min-h-screen bg-gray-100">
            <nav className="bg-white border-b border-gray-200">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex">
                            <div className="flex-shrink-0 flex items-center">
                                <Link href="/">
                                    <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>
                            <div className="hidden sm:ml-6 sm:flex sm:space-x-8">
                                <NavLink href={route('dashboard')} active={isActive('dashboard')}>
                                    ホーム
                                </NavLink>
                                <NavLink href={route('myteam.index')} active={isActive('myteam.index')}>
                                    Myチームトップ
                                </NavLink>
                                <NavLink href={route('team.list')} active={isActive('team.list')}>
                                    チーム検索画面
                                </NavLink>
                                <NavLink href={route('myteam.detail')} active={isActive('myteam.detail')}>
                                    チームプロフィール
                                </NavLink>
                                <NavLink href={route('logout')} method="post" as="button" active={false}>
                                    ログアウト
                                </NavLink>
                            </div>
                        </div>
                        <div className="-mr-2 flex items-center sm:hidden">
                            <button
                                onClick={() => setShowingNavigationDropdown(prev => !prev)}
                                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none"
                            >
                                <svg
                                    className="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        className={!showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        className={showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div className={showingNavigationDropdown ? 'block sm:hidden' : 'hidden sm:hidden'}>
                    <div className="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink href={route('dashboard')} active={isActive('dashboard')}>
                            ホーム
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={route('myteam.index')} active={isActive('myteam.index')}>
                            Myチームトップ
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={route('team.list')} active={isActive('team.list')}>
                            チーム検索画面
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={route('myteam.detail')} active={isActive('myteam.detail')}>
                            チームプロフィール
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={route('logout')} method="post" as="button">
                            ログアウト
                        </ResponsiveNavLink>
                    </div>
                    <div className="pt-4 pb-1 border-t border-gray-200">
                        <div className="px-4">
                            <div className="font-medium text-base text-gray-800">{user.name}</div>
                            <div className="font-medium text-sm text-gray-500">{user.email}</div>
                        </div>
                    </div>
                </div>
            </nav>

            {header && (
                <header className="bg-white shadow">
                    <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {header}
                    </div>
                </header>
            )}

            <main>{children}</main>
        </div>
    );
}