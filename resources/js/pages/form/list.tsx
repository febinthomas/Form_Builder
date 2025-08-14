import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Forms',
    href: '/form',
  },
];

export default function Forms({ forms }) {

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Forms" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="grid auto-rows-min gap-4 md:grid-cols-1">
          <div>
            <div className="flex justify-end">
              <Link
                href={route('form.create')}
                className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
              >
                Create Form
  </Link>
            </div>                    </div>

        </div>
        <div className="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">

          <div className="p-4">
            <table className="min-w-full border border-gray-300 rounded-lg overflow-hidden">
              <thead className="bg-gray-100">
                <tr>
                  <th className="text-left py-3 px-4 font-semibold text-gray-700">Title</th>
                  <th className="text-left py-3 px-4 font-semibold text-gray-700">User</th>
                  <th className="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                  <th className="text-center py-3 px-4 font-semibold text-gray-700 text-center">View</th>

                </tr>
              </thead>
              <tbody>
                {forms.data.map((form) => (
                  <tr
                    key={form.id}
                    className="border-t border-gray-200 hover:bg-gray-50 transition-colors"
                  >
                    <td className="py-3 px-4 font-medium text-gray-900">{form.title}</td>
                    <td className="py-3 px-4 text-gray-700">{form.user.name}</td>
                    <td className="py-3 px-4">
                      <span
                        className={`inline-block rounded-full px-3 py-1 text-xs font-semibold ${form.is_active == "1"
                          ? "bg-green-100 text-green-800"
                          : "bg-red-100 text-red-800"
                          }`}
                      >
                        {form.is_active == "1" ? "Active" : "Inactive"}
                      </span>
                    </td>
                    <td className="py-3 px-4 text-center align-middle">
                      <a
                        href={route('form.show', { form: form.id })}
                        aria-label={`View details for ${form.id.title}`}
                        title="View details"
                        className="inline-flex items-center justify-center p-1 rounded hover:bg-gray-100 text-blue-500 hover:text-blue-700 transition-colors"
                      >
                        View
                      </a>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
            <div className="mt-4 flex gap-2 justify-end">
              {forms.links
                .filter(link => link.url)
                .map((link, idx) => (
                  <Link
                    key={link.url || link.label + idx}
                    href={link.url}
                    dangerouslySetInnerHTML={{ __html: link.label }}
                    className={`px-3 py-1 border rounded ${link.active ? 'bg-blue-500 text-white' : ''
                      }`}
                  />
                ))
              }
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
