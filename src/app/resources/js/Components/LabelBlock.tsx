import React from 'react';

interface LabelBlockProps {
  label: string;
  required?: boolean;
  children: React.ReactNode;
  description?: string;
  className?: string;
}

export default function LabelBlock({
  label,
  required = false,
  children,
  description,
  className = '',
}: LabelBlockProps) {
  return (
    <div className={`mb-5 ${className}`}>
      <p className="text-sm text-gray-600 mb-1">
        {label}
        {required && (
          <span className="ml-2 inline-block text-xs text-white bg-red-600 rounded-full px-2 py-0.5 align-middle">
            必須
          </span>
        )}
      </p>

      {description && (
        <p className="text-xs text-gray-400 mb-1 leading-relaxed">{description}</p>
      )}

      <div className="text-base text-gray-900">
        {children}
      </div>
    </div>
  );
}
