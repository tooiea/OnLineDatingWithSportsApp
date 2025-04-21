import { Link } from '@inertiajs/react';

interface Props {
  href: string;
  label?: string;
  size?: 'sm' | 'md';
  className?: string;
}

export default function EditLinkButton({ href, label = '編集', size = 'sm', className = '' }: Props) {
  const sizeClasses = size === 'sm'
    ? 'text-sm px-3 py-1'
    : 'text-base px-4 py-2';

  return (
    <Link
      href={href}
      className={`inline-flex items-center gap-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded ${sizeClasses} ${className}`}
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        className="w-4 h-4"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        strokeWidth={2}
      >
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          d="M15.232 5.232l3.536 3.536M4 20h4l10.293-10.293a1 1 0 00-1.414-1.414L7 18.586V20z"
        />
      </svg>
      {label}
    </Link>
  );
}
